<?php

use Ramsey\Uuid\Uuid;
use Tuupola\Base32;

function breadcrumbs()
{

  $uri = service('uri');
  $segments = $uri->getSegments();
  $base_url = base_url();

  echo '<a href="' . $base_url . '">Home</a>';
  foreach ($segments as $key => $segment) {
      $url = $base_url . '/' . implode('/', array_slice($segments, 0, $key + 1));
      echo ' &raquo; <a href="' . $url . '">' . ucfirst($segment) . '</a>';
  }
}

function slugToTitle($str)
{
  return ucwords(str_replace('-', ' ', $str));
}

function logging($type, $content)
{
  switch ($type) {
    case 'account':
        $level = 3;
      break;
    
    case 'user_group':
        $level = 3;
      break;

    default:
        $level = 1;
      break;
  }
	$db = db_connect();
	$db->table('tb_logs')->insert([
		'log_type' => $type,
		'log_content' => $content,
    'log_level' => $level
	]);
}

function button($button, $label = null, $mode = 'a', $attr = null, $icon = null)
{
	if(!empty($button))
	{
		if(!is_null($label))
		{
			return '<'.$mode.' '.$attr.'><i class="'.$icon.'"></i> '.$label.'</'.$mode.'>';
		}
		else
		{
			return '<'.$mode.' '.$attr.' title="'.$button->label_menu.'"><i class="'.$icon.'"></i></'.$mode.'>';	
		}
	}
}

function slug($str)
{
	$str = preg_replace('/[^a-zA-Z0-9 ]/', '', strtolower($str));
  return preg_replace('/[\s+]/', '-', $str);
}

/**
 * Date Validation Function
 * 
 * Date validation using regex in ISO Format
 *
 * @access  public
 * @param   string  $date
 * @return  bool  
 * 
*/
function validate_date($date)
{
	return (bool) preg_match('/^((([1-9]\d{3})\-(0[13578]|1[02])\-(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2})\-(0[13456789]|1[012])\-(0[1-9]|[12]\d|30))|(([1-9]\d{3})\-02\-(0[1-9]|1\d|2[0-8]))|(([1-9]\d(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\-02\-29))$/', $date);
}

function lastDay($month = '') 
{
   if (empty($month)) {
      $month = date('Y-m');
   }

   $result = strtotime("{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));
   return date('Y-m-d', $result);
}

/**
 * Indonesian Date Function
 * 
 *
 * @access  public
 * @param   string  $date
 * @param   bool  $print_day
 * @param   bool  $time
 * @param   string $timezone
 * @return  string  
 * 
*/
function indonesian_date($date, $print_day = FALSE, $time = FALSE, $timezone = 'WIB')
{
  $day = array ( 1 =>    'Senin',
      'Selasa',
      'Rabu',
      'Kamis',
      'Jumat',
      'Sabtu',
      'Minggu'
    );

  $month = array (1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

  if(preg_match('/^\d+$/', $date)) 
  {
    if($time === true)
    {
      $date = date('Y-m-d H:i:s', $date);

      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0] . ' - ' . $time[1] . ' ' . $timezone;
    }
    else
    {
      $date = date('Y-m-d', $date);

      $split = explode('-', $date);
      $indo_date = $split[2] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0];
    }

    if ($print_day) {
      $num = date('N', strtotime($date));
      return $day[$num] . ', ' . $indo_date;
    }

    return $indo_date;
  }
  elseif(empty($date))
  {
    return '-';
  }
  else
  {
    if($time ===  true)
    {
      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0] . ' - ' . $time[1] . ' ' . $timezone;
    }
    else
    {
      $split = explode('-', $date);
      $time = explode(' ', $split[2]);
      $indo_date = $time[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[0];
    }

    if ($print_day) {
      $num = date('N', strtotime($date));
      return $day[$num] . ', ' . $indo_date;
    }

    return $indo_date;
  }
}

/**
 * Month to Rome Function
 * 
 *
 * @access  public
 * @param   string  $month
 * @return  string  
 * 
*/
function monthToRome($month)
{
    $monthRome = array (
      '01' => 'I',
      '02' => 'II',
      '03' => 'III',
      '04' => 'IV',
      '05' => 'V',
      '06' => 'VI',
      '07' => 'VII',
      '08' => 'VIII',
      '09' => 'IX',
      '10' => 'X',
      '11' => 'XI',
      '12' => 'XII'
    );
    
    return $monthRome[ $month ];
}

/**
 * Base64 URL Encode
 *
 * 
 * Encode data to Base64URL
 * Replacing “+” with “-”, “/” with “_”, and remove padding character from the end of line
 * 
 * @param string $data
 * @return boolean|string
 * 
*/
function base64url_encode($data)
{
  // First of all you should encode $data to Base64 string
  $b64 = base64_encode($data);

  // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
  if ($b64 === false) {
    return false;
  }

  // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
  $url = strtr($b64, '+/', '-_');

  // Remove padding character from the end of line and return the Base64URL result
  return rtrim($url, '=');
}

/**
 * Base64 URL Decode
 *
 * 
 * Decode data from Base64URL
 * 
 * @param string $data
 * @param boolean $strict
 * @return boolean|string
 * 
*/
function base64url_decode($data, $strict = false)
{
  // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
  $b64 = strtr($data, '-_', '+/');

  // Decode Base64 string and return the original data
  return base64_decode($b64, $strict);
}

function parseRoles($roles) {
  $roles = json_decode($roles['roles'], TRUE);
  $btn = [];
  foreach ($roles['btnmenu'] as $value) {
      $btn[] = $value['menu_slug'];
  }

  $mainmenu = $roles['mainmenu'];
  usort($mainmenu, fn($a, $b) => $a['menu_sequence'] <=> $b['menu_sequence']);

  $submenu = $roles['submenu'];
  if(!empty($submenu)) {
      usort($submenu, fn($a, $b) => $a['menu_sequence'] <=> $b['menu_sequence']);
  }

  return array('mainmenu' => $mainmenu, 'submenu' => $submenu, 'btnmenu' => $btn);
}

function imageBase64($path)
{
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = @file_get_contents($path);
	return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

function isUUID($str)
{
  return (bool) preg_match(
      '/^[0-9a-f]{8}-[0-9a-f]{4}-1[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
      $str
  );
}

function isBase64($string)
{
    if (strlen($string) % 4 !== 0) {
        return false;
    }

    if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $string)) {
        return false;
    }

    // Decode string dan cek apakah hasil encoding ulang sama dengan aslinya
    $decoded = base64_decode($string, true);
    return $decoded !== false && base64_encode($decoded) === $string;
}

function encrypt($str, $key, $blocksize = 64)
{
  $encrypter = service('encrypter');
  try {
    return base64_encode($encrypter->encrypt($str, ['key' => $key, 'blockSize' => $blocksize]));
  } catch (\Exception $e) {
    return $e->getMessage();
  }
}

function decrypt($str, $key, $blocksize = 64)
{
  if(!isBase64($str)) return null;

  $encrypter = service('encrypter');

  try {
    return $encrypter->decrypt(base64_decode($str), ['key' => $key, 'blockSize' => $blocksize]);
  } catch (\Exception $e) {
    return $e->getMessage();
  }
}

function search($query, $data) {
    $results = [];
    foreach ($data as $item) {
        $distance = levenshtein($query, $item);
        if ($distance <= 2) { // Sesuaikan threshold jarak
            $results[] = $item;
        }
    }
    return $results;
}

function pagination($rowperpage, $total_row, $base_url)
{
    $config['base_url']         = $base_url;
    $config['total_rows']       = $total_row;
    $config['per_page']         = $rowperpage;
    $config['use_page_numbers'] = TRUE;
    $config['full_tag_open']    = '<ul class="justify-content-center">';
    $config['full_tag_close']   = '</ul>';
    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['cur_tag_open']     = '<li class="active"><a href="#">';
    $config['cur_tag_close']    = '</a></li>';
    $config['next_tag_open']    = '<li>';
    $config['next_tag_close']   = '</li>';
    $config['prev_tag_open']    = '<li>';
    $config['prev_tag_close']   = '</li>';
    $config['first_tag_open']   = '<li>';
    $config['first_tag_close']  = '</li>';
    $config['last_tag_open']    = '<li>';
    $config['last_tag_close']   = '</li>';
    $config['last_link']        = 'Last';
    $config['first_link']       = 'First';

    return $config;
}

function bulanArsip($bulan, $tahun)
{
  $month = array (
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10=> 'Oktober',
      11=> 'November',
      12=> 'Desember'
    );

    return $month[ltrim($bulan, '0')] .' '. $tahun; 
}

function getBrowserName($userAgent)
{
  if (strpos($userAgent, 'Opera') || strpos($userAgent, 'OPR/')) {
    return 'Opera';
  } elseif (strpos($userAgent, 'Edge')) {
    return 'Edge';
  } elseif (strpos($userAgent, 'Chrome')) {
    return 'Chrome';
  } elseif (strpos($userAgent, 'Safari')) {
    return 'Safari';
  } elseif (strpos($userAgent, 'Firefox')) {
    return 'Firefox';
  } elseif (strpos($userAgent, 'MSIE') || strpos($userAgent, 'Trident/7')) {
    return 'Internet Explorer';
  }

  return 'Other';
}

function docClassification($classification)
{
  $class = [
    'subbagumum' => 'Sub Bagian Umum',
    'statsos' => 'Statistik Sosial',
    'statprod' => 'Statistik Produksi',
    'statdist' => 'Statistik Distribusi',
    'nerwilis' => 'Neraca Wilayah dan Analisis Statistik',
    'ipds' => 'Integrasi Pengolahan dan Diseminasi Statistik'
  ];

  return $class[$classification];
}

function uuid($version = 4, $ulid = false)
{
  switch ($version) {
    case 1:
      $uuid = Uuid::uuid1();
      break;
    
    case 2:
      $uuid = Uuid::uuid2(Uuid::DCE_DOMAIN_ORG);
      break;

    case 3:
      $uuid = Uuid::uuid3(Uuid::NAMESPACE_URL, base_url());
      break;

    case 5:
      $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, base_url());
      break;

    case 6:
      $uuid = Uuid::uuid6();
      break;

    case 7:
      $uuid = Uuid::uuid7();
      break;
      
    default:
      $uuid = Uuid::uuid4();
      break;
    }
    
    if($uuid === 7 && $ulid === true) {
      $crockford = new Base32([
          'characters' => Base32::CROCKFORD,
          'padding' => false,
          'crockford' => true,
      ]);
      $bytes = str_pad($uuid->getBytes(), 20, "\x00", STR_PAD_LEFT);

      $encoded = $crockford->encode($bytes);

      return substr($encoded, 6);
    } else {
      return $uuid->toString();
    }
}