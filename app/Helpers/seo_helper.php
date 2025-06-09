<?php

function menuItems($nav)
{
	$list = [];
	foreach ($nav as $n) {
		$list[] = [
			"@type" => "ListItem",
			"position" => $n['nav_sequence'],
			"name" => $n['nav_name'],
			"item" => base_url($n['nav_slug'])
		];
	}

	return $list;
}

function ldjson_home($settings, $icon_info)
{
	return array(
      "@context" => "https => //schema.org",
      "@graph" => [
      [
        "@type" => "WebPage",
        "@id" =>  base_url(),
        "url" =>  base_url(),
        "name" =>  $settings['site_name'],
        "primaryImageOfPage" => [
          "@id" =>  base_url($settings['site_banner']),
          "url" =>  base_url($settings['site_banner']) 
        ],
        "image" => [
          "@id" =>  base_url($settings['site_banner']),
          "url" =>  base_url($settings['site_banner']) 
        ],
        "logo" => [
	        "@type" => "ImageObject",
	        "url" => site_url($settings['site_icon'])
	    ],
	    "sameAs" => [
	        $settings['facebook'],
	        $settings['twitter'],
	        $settings['instagram'],
	        $settings['linkedin'],
	    ],
        "thumbnailUrl" =>  site_url($settings['site_icon']) ,
        "datePublished" => "2020-04-08T14:29:42+00:00",
        "dateModified" => "2022-02-20T10:20:24+00:00",
        "description" =>  $settings['site_description'],
        "inLanguage" => "id",
        "potentialAction" => [[
          "@type" => "ReadAction",
          "target" => [ base_url('post') ]
        ]]
      ],
      [
        "@type" => "ImageObject",
        "inLanguage" => "id",
        "@id" =>  base_url('#primaryimage') ,
        "url" =>  site_url($settings['site_icon']) ,
        "contentUrl" =>  site_url($settings['site_icon']) ,
        "width" => $icon_info[0],
        "height" => $icon_info[1]
      ],
      array(
	    "@type" => "BreadcrumbList",
	    "itemListElement" => menuItems(cache()->get('navbars'))
	  )]
    );
}

function ldjson_index($title, $data, $settings, $mainImage, $icon_info, $create, $modify)
{
	return array(
		"@context" => "https://schema.org",
      	"@graph" => array(
      		array(
		        "@type" => "WebPage",
		        "@id" => base_url(),
		        "url" => base_url(),
		        "name" => $title,
		        "isPartOf" => ["@id" => base_url('#website')],
		        "primaryImageOfPage" => ["@id" => $mainImage, "url" => $mainImage],
		        'image' => ["@id" => $mainImage, "url" => $mainImage],
		        "thumbnailUrl" => $mainImage,
		        "datePublished" => $create->format(DateTime::ISO8601_EXPANDED),
		        "dateModified" => $modify->format(DateTime::ISO8601_EXPANDED),
		        "description" => trailer($data[0]['post_content'],150),
		        "inLanguage" => "id",
		        "potentialAction" => array(
		        	[
		        		"@type" => "ReadAction", 
		        		"target" => [base_url($data[0]['post_slug'])]
		        	]
		        )
      		),
      		array(
      			"@type" => "ImageObject",
		        "inLanguage" => "id",
		        "@id" => $mainImage,
		        "url" => $mainImage,
		        "contentUrl" => site_url($settings['site_icon']),
		        "width" => ($icon_info[0] ?? ''),
		        "height" => ($icon_info[1] ?? '')
      		),
      		array(
				"@type" => "BreadcrumbList",
				"itemListElement" => menuItems(cache()->get('navbars'))
			),
      		array(
		        "@type" =>"WebSite",
		        "url" => base_url(),
		        "name" => $settings['site_name'],
		        "logo" => [
			        "@type" => "ImageObject",
			        "url" => site_url($settings['site_icon'])
			    ],
		        "description" => $settings['site_tagline'],
		        "sameAs" => [
			        $settings['facebook'],
			        $settings['twitter'],
			        $settings['instagram'],
			        $settings['linkedin']
			    ],
		        "potentialAction" => array([
		          "@type" => "SearchAction",
		          "target" => [
		            "@type" => "EntryPoint",
		            "urlTemplate" => base_url('cari/?')."q=[query]"
		          ],
		          "query-input" =>"required name=query"
		        ]),
		        "inLanguage" =>"id"
      		)
      	)
	);
}