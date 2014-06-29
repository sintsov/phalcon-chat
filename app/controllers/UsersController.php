<?php
/**
 * Controller management users
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use MainSource\Models\Users;
use Phalcon\Mvc\Model\Message,
    MainSource\Messages\Exception as MessageException,
    Phalcon\Http\Response,
    Phalcon\Mvc\View;

class UsersController extends ControllerBase {

    public function getActualUsersAction(){
        $this->view->disable();
        $response = new Response();
        $users = $this->users->getUsersList();
        if ($users){
            // TODO: future need js templater and response json data and think only status!!! If users > 100
            $html = $this->view->getRender('chat', 'users', array('users' => $users), function ($view) {
                $view->setRenderLevel(View::LEVEL_LAYOUT);
            });
            $response->setJsonContent(array('status' => 'success', 'html' => utf8_encode($html)));
        } else {
            // TODO
        }
        return $response;
    }


    public function changeAvatarAction(){
        $this->view->disable();
        $response = new Response();
        $user = $this->auth->getUser();
        if ($user){
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file){
                    switch ($file->getType()) {
                        case 'image/jpeg':
                        case 'image/png':
                            // Phalcon\Image's GD & Imagick adapter is currently only available in Phalcon 1.3
                            $imageName = $this->thumbnail($file->getTempName(), $file->getType(), 32, 32);
                            $user->avatar = '/uploads/' . $imageName;
                            if ($user->save()){
                                $response->setJsonContent(array('status' => 'success', 'img' => $user->avatar));
                            } else{
                                $response->setJsonContent(array('status' => 'error', 'message' => 'Error in trying to save a file'));
                            }
                            break;
                        default:
                            $response->setJsonContent(array('status' => 'error', 'message' => 'Not have support file type. Only png/jpeg'));
                            break;
                    }
                }
            }
        }
        return $response;
    }


    function thumbnail($image_path, $extension, $thumb_width, $thumb_height) {

        if (!(is_integer($thumb_width) && $thumb_width > 0) && !($thumb_width === "*")) {
            echo "The width is invalid";
            exit(1);
        }

        if (!(is_integer($thumb_height) && $thumb_height > 0) && !($thumb_height === "*")) {
            echo "The height is invalid";
            exit(1);
        }

        switch ($extension) {
            case "image/jpg":
            case "image/jpeg":
                $source_image = imagecreatefromjpeg($image_path);
                break;
            case "image/gif":
                $source_image = imagecreatefromgif($image_path);
                break;
            case "image/png":
                $source_image = imagecreatefrompng($image_path);
                break;
            default:
                exit(1);
                break;
        }

        $source_width = imageSX($source_image);
        $source_height = imageSY($source_image);

        if (($source_width / $source_height) == ($thumb_width / $thumb_height)) {
            $source_x = 0;
            $source_y = 0;
        }

        if (($source_width / $source_height) > ($thumb_width / $thumb_height)) {
            $source_y = 0;
            $temp_width = $source_height * $thumb_width / $thumb_height;
            $source_x = ($source_width - $temp_width) / 2;
            $source_width = $temp_width;
        }

        if (($source_width / $source_height) < ($thumb_width / $thumb_height)) {
            $source_x = 0;
            $temp_height = $source_width * $thumb_height / $thumb_width;
            $source_y = ($source_height - $temp_height) / 2;
            $source_height = $temp_height;
        }

        $target_image = ImageCreateTrueColor($thumb_width, $thumb_height);

        imagecopyresampled($target_image, $source_image, 0, 0, $source_x, $source_y, $thumb_width, $thumb_height, $source_width, $source_height);

        $path = $this->config->application->uploadsDir;
        $imageName = base64_encode(basename($image_path));

        switch ($extension) {
            case "image/jpg":
            case "image/jpeg":
                $fullImageName = $imageName . ".jpg";
                imagejpeg($target_image, $path . $fullImageName);
                break;
            case "image/gif":
                $fullImageName =  $imageName . ".gif";
                imagegif($target_image, $path . $fullImageName);
                break;
            case "image/png":
                $fullImageName =  $imageName . ".png";
                imagepng($target_image, $path . $fullImageName);
                break;
            default:
                exit(1);
                break;
        }

        imagedestroy($target_image);
        imagedestroy($source_image);

        return $fullImageName;
    }

} 