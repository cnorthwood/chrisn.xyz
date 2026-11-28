<?php
/**
 * Plugin Name: S3 Uploads endpoint
 * Description: Points S3 Uploads at the cluster's own S3-compatible object store, rather than AWS
 */

add_filter(
    's3_uploads_s3_client_params',
    function (array $params): array {
        if (defined('S3_UPLOADS_ENDPOINT') && S3_UPLOADS_ENDPOINT) {
            $params['endpoint'] = S3_UPLOADS_ENDPOINT;
            // RustFS serves buckets as paths, not subdomains
            $params['use_path_style_endpoint'] = true;
        }
        return $params;
    }
);
