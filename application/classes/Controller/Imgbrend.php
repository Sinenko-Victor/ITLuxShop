<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Imgbrend extends Controller {
 
    public function action_index()
    {
        $go = $this->request->param('go');
        $width = (int) $this->request->param('width');
        $height = (int) $this->request->param('height');
        
        $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/brends/$go.jpg";
        if (file_exists($file_img)) 
        {
            $imggoods[1]="/media/foto/brends/$go.jpg";
        } 
        else 
        {
            $imggoods[1]="/media_admin/img/nofoto.jpg";
        }
        
        //echo$imggoods[1];
        $rendered = FALSE;
        if ($width AND $height)
        {
            $filename = DOCROOT.$imggoods[1];
 
            if (is_file($filename))
            {
                $this->_render_image($filename, $width, $height);
                $rendered = TRUE;
            }
        }
 
        if ( ! $rendered)
        {
            $this->response->status(404);
        }
    }
 
    protected function _render_image($filename, $width, $height)
    {
        // Calculate ETag from original file padded with the dimension specs
        $etag_sum = md5(base64_encode(file_get_contents($filename)).$width.','.$height);
 
        // Render as image and cache for 1 hour
        $this->response->headers('Content-Type', 'image/jpeg')
            ->headers('Cache-Control', 'max-age='.Date::HOUR.', public, must-revalidate')
            ->headers('Expires', gmdate('D, d M Y H:i:s', time() + Date::HOUR).' GMT')
            ->headers('Last-Modified', date('r', filemtime($filename)))
            ->headers('ETag', $etag_sum);
 
        if (
            $this->request->headers('if-none-match') AND
            (string) $this->request->headers('if-none-match') === $etag_sum)
        {
            $this->response->status(304)
                ->headers('Content-Length', '0');
        }
        else
        {
            $result = Image::factory($filename)
                ->resize($width, $height)
                ->render('jpg');
 
            $this->response->body($result);
        }
    }
}