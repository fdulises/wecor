<?php
	namespace wecor;

	require_once THEME_PATH.'/php/conf/routes.conf.php';

	event::add('rem_unshort', 'remove_unused_shortcode');
	function remove_unused_shortcode($content){

		$shortlist = [
			'/\[vc_row\]/i' => "",
			'/\[vc_column\]/i' => "",
			'/\[vc_column_text\]/i' => "",
			'/\[vc_tabs\]/i' => "",
			'/\[vc_tab(.*)\]/i' => "",
			'/\[\/vc_row\]/i' => "",
			'/\[\/vc_column\]/i' => "",
			'/\[\/vc_column_text\]/i' => "",
			'/\[\/vc_tabs\]/i' => "",
			'/\[\/vc_tab(.*)\]/i' => "",
		];
		$content = preg_replace(array_keys($shortlist), array_values($shortlist), $content);
		return $content;
	}
