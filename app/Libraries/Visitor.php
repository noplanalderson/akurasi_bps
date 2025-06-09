<?php namespace App\Libraries;

use App\Modules\Frontend\Models\VisitorModel;
use CodeIgniter\Cookie\Cookie;
use Ramsey\Uuid\Uuid;

class Visitor {

    protected $userAgent;

	protected $agent;

    protected $visitorModel;

	protected $referred = '';

	protected $ip = '127.0.0.1';

	protected $hits = 1;

	public function __construct()
	{
        $this->visitorModel = new VisitorModel;
        $this->agent =  new \CodeIgniter\HTTP\UserAgent;

		$this->ip 	 	= $this->ip();
		$this->userAgent= $this->agent();
		$this->referred = $this->referred();
	}

	protected function referred()
	{  
		return ($this->agent->isReferral() == true) ? $this->agent->getReferrer() : '';
	}

	protected function agent()
	{
        if ($this->agent->isBrowser()) {
            $currentAgent = $this->agent->getBrowser() . ' ' . $this->agent->getVersion();
        } elseif ($this->agent->isRobot()) {
            $currentAgent = $this->agent->getRobot();
        } elseif ($this->agent->isMobile()) {
            $currentAgent = $this->agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }

		return array(
			'agent' => $currentAgent,
			'version' => $this->agent->getVersion(),
			'platform' => $this->agent->getPlatform(),
			'ua_string' => $this->agent->getAgentString()
		);
	}

	protected function ip()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) == true) ? $ip : (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) == true ? $ip : '0.0.0.0');
	}

	protected function location()
	{
		$url = 'https://api.findip.net/'.$this->ip.'/?token=76fa3410c9f04582b0d51f16175a32e2';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		try {

			$res = curl_exec($curl);
			curl_close($curl);

			$res  = json_decode($res, true);
			
			if(empty($res['country'])) 
			{
				return '000';
			}
			else
			{
				return $res['country']['iso_code'];
			}
			
		} catch (\Exception $e) {
			return '000';			
		}
	}

	public function addVisitor()
	{
		$data = array(
			'last_counter' => date('Y-m-d'),
			'referred' => $this->agent->getReferrer(),
			'agent' => $this->userAgent['agent'],
			'version' => $this->userAgent['version'],
			'platform' => $this->userAgent['platform'],
			'UAString' => $this->userAgent['ua_string'],
			'ip' => $this->ip,
			'location' => $this->location()
		);

		return $this->visitorModel->insert($data);
	}

	public function create_cookie()
	{
        if(cookies()->has('aii_visitor') == false) 
	   	{
            $UUID = Uuid::uuid4();
            set_cookie(
                'visitor',
                $UUID,
                7200,
                '',
                '/',
                'aii_',
                false,
                true,
                false,
                Cookie::SAMESITE_LAX,
            );
            return cookies()->get('aii_visitor')->getValue();
        }
	}

	public function viewer($post)
	{
		$status = 0;

		if(empty(get_cookie($post['slug'])))
	   	{
			$status = $this->visitorModel->addViewer($post);
			if($status == 1) {
				set_cookie(
					$post['slug'],
					hash('gost',$post['slug']),
					7200,
					'',
					'/',
					'aii_',
					false,
					true,
					false,
					Cookie::SAMESITE_LAX,
				);
			}
		}

		return $status;
	}
}