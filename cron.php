<?php

require __DIR__ . "/vendor/autoload.php";

use mm0\ImageManager;
use mm0\ImageManager\Log;

/* Define Paths */
// non-recursive directory:
$directory = new ImageManager\Destinations\Directory("/var/www/admin/web/img/posts/");
//$directory = new ImageManager\Destinations\Directory(__DIR__."/images/posts");
//$directory = new ImageManager\Destinations\RecursiveDirectory(__DIR__."/images/");
//$file = new ImageManager\Destinations\File(__DIR__."/images/posts/BM1oTUtgfXw.png");

$filesystem_configuration = new ImageManager\Configuration\Filesystem();
$filesystem_configuration->addDestination($directory);
//$filesystem_configuration->addDestination($file);

/* Define S3 destination */
$s3_configuration = new ImageManager\Configuration\S3();
$s3_configuration->setRegion("us-west-1");
$s3_configuration->setBucket("admin-web-image-posts");

Log::setLogLevel("DEBUG");
/* Define Valid File Types */
$file_types = array(
    new ImageManager\FileTypes\JPEG(),
    new ImageManager\FileTypes\PNG(),
    new ImageManager\FileTypes\BMP(),
    new ImageManager\FileTypes\TIFF(),
    new ImageManager\FileTypes\GIF(),
);

/* Configure Connection type (shell or SSH) */
$connection = new ImageManager\LocalShell\Connection();

/* Configure Manager */
$manager = new ImageManager\Manager();
$manager->setFilesystemConfiguration($filesystem_configuration);
$manager->setS3Configuration($s3_configuration);
$manager->setConnection($connection);
$manager->setFileCountLimit(0); // process 10 files at a time

// set post action
$post_action = new ImageManager\Actions\Null();
$manager->addPostAction($post_action);

// add File Type Validation
foreach($file_types as $file_type){
    $manager->addValidFileType($file_type);
}

$manager->run();
// Run
echo "matt";
exit(0);
