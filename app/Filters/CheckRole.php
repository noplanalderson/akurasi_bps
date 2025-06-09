<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class CheckRole implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = new \CodeIgniter\HTTP\URI(current_url());

        // if user not logged in
        if(! session()->get('uid') && ! session()->get('gid')){
            // then redirct to login page
            $next = (!empty(current_url()) ? '?next='.str_replace(base_url(), '', current_url()) : '');
            return redirect()->to('auth'.$next); 
        } else {
                       
            $main = []; 
            $sub = [];
            $btn = [];

            foreach (session()->get('user_menu') as $value){
                $main[] = $value['menu_slug'];
            }
            foreach (session()->get('user_submenu') as $value){
                $sub[] = $value['menu_slug'];
            }
            foreach (session()->get('user_btnmenu') as $value){
                $btn[] = $value;
            }
            
            $countSegment = count($uri->getSegments());
            
            if($countSegment > 2) {
                if(!in_array($uri->getSegment(2).'/'.$uri->getSegment(3), array_merge($main, $sub, $btn))) {
                    return redirect()->to('error/403');
                }
            } else {
                if(!in_array($uri->getSegment(2), array_merge($main, $sub, $btn))) {
                    return redirect()->to('error/403');
                }
            }
        }
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}