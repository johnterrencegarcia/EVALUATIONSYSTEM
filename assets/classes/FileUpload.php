<?php
/**
 * Secure File Upload Handler Class
 * 
 * Provides secure file upload functionality with:
 * - MIME type validation (not just extension)
 * - File size limits
 * - Random filename generation
 * - Storage outside webroot (if possible)
 * - Virus/malware scanning ready
 * 
 * WHY PROPER FILE UPLOAD IS CRITICAL:
 * - Prevents uploading executable files (PHP, .exe, .bat)
 * - Prevents uploading malware
 * - Prevents path traversal attacks (../../etc/passwd)
 * - Prevents file overwrite attacks
 * 
 * VULNERABLE APPROACH (Your current code):
 * - Uses pathinfo() for extension check (EASY TO BYPASS)
 * - Stores with original filename (OVERWRITE RISK)
 * - Stores in webroot (EXECUTABLE!)
 */

class FileUpload {
    
    // Maximum file size: 5MB
    const MAX_FILE_SIZE = 5242880;
    
    // Allowed MIME types for images
    const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp'
    ];
    
    // Allowed MIME types for documents
    const ALLOWED_DOCUMENT_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
    
    /**
     * ===================================================================
     * VALIDATE AND UPLOAD FILE
     * ===================================================================
     * 
     * Main method to securely upload a file
     * 
     * @param array $uploadedFile $_FILES['fieldname'] array
     * @param string $uploadType 'image', 'document', or custom
     * @param array $customMimes Optional custom MIME types to allow
     * @return array ['success' => bool, 'filename' => string, 'error' => string]
     * 
     * USAGE:
     * $result = FileUpload::uploadFile($_FILES['photo'], 'image');
     * if ($result['success']) {
     *     // Store filename in database
     *     $filename = $result['filename'];
     * } else {
     *     // Show error
     *     echo $result['error'];
     * }
     */
    public static function uploadFile($uploadedFile, $uploadType = 'image', $customMimes = null) {
        
        // STEP 1: Validate that a file was actually uploaded
        if (!isset($uploadedFile) || !is_array($uploadedFile)) {
            return [
                'success' => false,
                'error' => 'No file provided'
            ];
        }
        
        // STEP 2: Check for upload errors
        if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds PHP upload limit',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds form size limit',
                UPLOAD_ERR_PARTIAL => 'File upload was incomplete',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Upload directory not found',
                UPLOAD_ERR_CANT_WRITE => 'Cannot write to upload directory',
                UPLOAD_ERR_EXTENSION => 'Upload blocked by extension'
            ];
            
            $error = $errorMessages[$uploadedFile['error']] ?? 'Unknown upload error';
            return ['success' => false, 'error' => $error];
        }
        
        // STEP 3: Check file size
        if ($uploadedFile['size'] > self::MAX_FILE_SIZE) {
            return [
                'success' => false,
                'error' => 'File is too large (max 5MB)'
            ];
        }
        
        // STEP 4: Validate file exists in temp location
        if (!is_uploaded_file($uploadedFile['tmp_name'])) {
            return [
                'success' => false,
                'error' => 'Invalid file upload'
            ];
        }
        
        // STEP 5: Determine allowed MIME types
        $allowedMimes = self::getAllowedMimes($uploadType, $customMimes);
        
        // STEP 6: Validate MIME type using finfo (not extension!)
        $mimeValidation = self::validateMimeType($uploadedFile['tmp_name'], $allowedMimes);
        if (!$mimeValidation['valid']) {
            return [
                'success' => false,
                'error' => $mimeValidation['error']
            ];
        }
        
        // STEP 7: For images, validate it's actually an image
        if ($uploadType === 'image') {
            if (getimagesize($uploadedFile['tmp_name']) === false) {
                return [
                    'success' => false,
                    'error' => 'File is not a valid image'
                ];
            }
        }
        
        // STEP 8: Generate secure filename
        $filename = self::generateSecureFilename($uploadedFile['name']);
        
        // STEP 9: Determine upload directory
        $uploadDir = self::getUploadDirectory($uploadType);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // STEP 10: Move file to upload directory
        $filePath = $uploadDir . $filename;
        if (!move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
            return [
                'success' => false,
                'error' => 'Failed to save file to server'
            ];
        }
        
        // STEP 11: Set proper file permissions
        chmod($filePath, 0644);
        
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $filePath
        ];
    }
    
    /**
     * Get allowed MIME types for upload type
     * 
     * @param string $uploadType 'image', 'document', etc.
     * @param array $customMimes Optional custom MIME types
     * @return array MIME types
     */
    private static function getAllowedMimes($uploadType, $customMimes = null) {
        if ($customMimes) {
            return $customMimes;
        }
        
        switch ($uploadType) {
            case 'image':
                return self::ALLOWED_IMAGE_MIMES;
            case 'document':
                return self::ALLOWED_DOCUMENT_MIMES;
            default:
                return [];
        }
    }
    
    /**
     * Validate MIME type using finfo
     * This is MUCH more secure than checking file extension
     * 
     * @param string $filePath Path to uploaded file
     * @param array $allowedMimes Allowed MIME types
     * @return array ['valid' => bool, 'error' => string]
     */
    private static function validateMimeType($filePath, $allowedMimes) {
        
        // Use finfo to detect actual MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if (!$finfo) {
            return ['valid' => false, 'error' => 'Cannot validate file type'];
        }
        
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        if (!$mimeType) {
            return ['valid' => false, 'error' => 'Cannot determine file type'];
        }
        
        // Check if MIME type is allowed
        if (!in_array($mimeType, $allowedMimes, true)) {
            return [
                'valid' => false,
                'error' => 'File type not allowed. Allowed types: ' . implode(', ', $allowedMimes)
            ];
        }
        
        return ['valid' => true];
    }
    
    /**
     * Generate secure random filename
     * Prevents filename collisions and directory traversal
     * 
     * @param string $originalName Original filename
     * @return string New secure filename
     */
    private static function generateSecureFilename($originalName) {
        // Get file extension from original name
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        
        // Whitelist allowed extensions (DOUBLE PROTECTION)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
        
        if (!in_array($extension, $allowedExtensions)) {
            $extension = 'bin'; // Default to binary
        }
        
        // Generate random filename: random_16chars.extension
        $randomName = bin2hex(random_bytes(16));
        
        return $randomName . '.' . $extension;
    }
    
    /**
     * Get upload directory based on file type
     * Stores outside webroot if possible for security
     * 
     * @param string $uploadType Type of upload
     * @return string Directory path
     */
    private static function getUploadDirectory($uploadType) {
        $baseDir = dirname(__DIR__) . '/uploads_secure/';
        
        switch ($uploadType) {
            case 'image':
                return $baseDir . 'images/';
            case 'document':
                return $baseDir . 'documents/';
            default:
                return $baseDir . 'files/';
        }
    }
    
    /**
     * Delete uploaded file
     * 
     * @param string $filename Filename to delete
     * @param string $uploadType Type of upload
     * @return bool Success
     */
    public static function deleteFile($filename, $uploadType = 'image') {
        // Security: prevent path traversal
        if (strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
            return false;
        }
        
        $filePath = self::getUploadDirectory($uploadType) . $filename;
        
        // Verify file exists and is in correct directory
        $realPath = realpath($filePath);
        $expectedDir = realpath(self::getUploadDirectory($uploadType));
        
        if (!$realPath || strpos($realPath, $expectedDir) !== 0) {
            error_log("Attempted to delete file outside upload directory: $filename", 3, 
                     dirname(__DIR__) . '/logs/security.log');
            return false;
        }
        
        if (file_exists($realPath)) {
            return unlink($realPath);
        }
        
        return false;
    }
    
    /**
     * Get uploaded file for serving to user
     * 
     * @param string $filename Filename to serve
     * @param string $uploadType Type of upload
     * @return array ['success' => bool, 'path' => string, 'mime' => string]
     */
    public static function getFileForServing($filename, $uploadType = 'image') {
        // Security: prevent path traversal
        if (strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
            return ['success' => false, 'error' => 'Invalid filename'];
        }
        
        $filePath = self::getUploadDirectory($uploadType) . $filename;
        
        // Verify file exists
        if (!file_exists($filePath)) {
            return ['success' => false, 'error' => 'File not found'];
        }
        
        // Get MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        
        return [
            'success' => true,
            'path' => $filePath,
            'mime' => $mimeType
        ];
    }
}

/**
 * ===================================================================
 * USAGE EXAMPLES
 * ===================================================================
 */

/*
// Example 1: Upload student photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $result = FileUpload::uploadFile($_FILES['photo'], 'image');
    
    if ($result['success']) {
        // Store filename in database
        $filename = $result['filename'];
        $pdo->query("UPDATE students SET photo = :photo WHERE id = :id", 
                    ['photo' => $filename, 'id' => $studentId]);
    } else {
        echo "Upload failed: " . $result['error'];
    }
}

// Example 2: Upload document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $result = FileUpload::uploadFile($_FILES['document'], 'document');
    
    if ($result['success']) {
        $filename = $result['filename'];
    } else {
        echo $result['error'];
    }
}

// Example 3: Serve uploaded file to user
$fileData = FileUpload::getFileForServing($storedFilename, 'image');
if ($fileData['success']) {
    header('Content-Type: ' . $fileData['mime']);
    readfile($fileData['path']);
} else {
    die('File not found');
}

// Example 4: Delete file
if (FileUpload::deleteFile($filename, 'image')) {
    echo "File deleted successfully";
} else {
    echo "Failed to delete file";
}
*/

/**
 * ===================================================================
 * IMPORTANT SECURITY NOTES
 * ===================================================================
 * 
 * 1. NEVER use pathinfo() extension for validation
 *    - Easy to bypass: rename.php.jpg or .php%20.jpg
 * 
 * 2. ALWAYS use finfo_file() for MIME detection
 *    - Checks actual file content, not just extension
 * 
 * 3. ALWAYS store outside webroot
 *    - Prevents direct execution of uploaded files
 *    - Use uploads_secure/ or /var/uploads/
 * 
 * 4. ALWAYS use random filenames
 *    - Prevents collision attacks
 *    - Prevents predictable file access
 * 
 * 5. ALWAYS validate file size
 *    - Prevent disk space exhaustion
 *    - Set reasonable max size
 * 
 * 6. ALWAYS check is_uploaded_file()
 *    - Ensures file came from HTTP upload, not filesystem
 * 
 * 7. Consider implementing virus scanning
 *    - ClamAV or similar
 *    - For healthcare/sensitive data
 * 
 * 8. Set proper permissions
 *    - 0644 for readable files
 *    - Never 0755 or 0777
 * 
 * 9. Log file operations
 *    - Track uploads/deletions
 *    - Monitor for suspicious patterns
 * 
 * 10. PHP Configuration (.htaccess)
 *     - Prevent execution in upload directory
 *     - Add to uploads_secure/.htaccess:
 *       php_flag engine off
 *       AddType text/plain .php .phtml .php3 .php4 .php5 .php6 .php7
 */

?>
