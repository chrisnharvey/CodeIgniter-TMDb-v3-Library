<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter TMDb (The Movie Database) API Library
 * 
 * Author: Chris Harvey
 * Website: http://www.chrisnharvey.com/
 * Email: chris@chrisnharvey.com
 *
 * Originally developed for Movie Notifications (http://www.movienotifications.com/)
 * 
 **/
 
class Tmdb
{
	
	private $_CI;
	private $_api_key;
	private $_language;
	
	private $_api_url = 'http://api.themoviedb.org/3/';
	
	public function __construct()
	{
		$this->_CI =& get_instance(); // Get the CodeIgniter super-object
		
		// Set the default settings based on the config
		$this->_CI->load->config('tmdb');
		$this->_api_key  = $this->_CI->config->item('tmdb_key');
		$this->_language = $this->_CI->config->item('tmdb_language');
	}
	
	
	/********************************
	 * Functions that set variables *
	 ********************************/
	
	public function set_language($iso_code)
	{
		$this->_language = $iso_code;
		
		return $this; // Allow method chaining
	}
	
	public function set_key($key)
	{
		$this->_api_key = $key;
		
		return $this; // Allow method chaining
	}

/////////////////////////////////////////////////////////////////////////////////////
	
	/********************************
	 *		  	 Search		 		*
	 ********************************/
	
	public function search_movies($query, $page = 1, $include_adult = FALSE)
	{
		$params = array(
			'query'			=> urlencode($query),
			'page'			=> $page,
			'include_adult'	=> $include_adult
		);
		
		return $this->_call('search/movie', $params);
	}
	
	public function search_people($query, $page = 1, $include_adult = FALSE)
	{
		$params = array(
			'query'			=> $query,
			'page'			=> $page,
			'include_adult'	=> $include_adult
		);
		
		return $this->_call('search/person', $params);
	}

/////////////////////////////////////////////////////////////////////////////////////

	/********************************
	 *		  	 Movies		 		*
	 ********************************/
	
	public function collection($id)
	{	
		return $this->_call('collection/' . $id);
	}
	
	public function movie_info($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id, $params);
	}
	
	public function movie_alternate_titles($id, $country = NULL, $append = NULL)
	{
		$params = array(
			'country'		=> $country,
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/alternative_titles', $params);
	}
	
	public function movie_casts($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/casts', $params);
	}
	
	public function movie_images($id, $country = NULL, $append = NULL)
	{
		$params = array(
			'country'		=> $country,
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/images', $params);
	}
	
	public function movie_keywords($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/keywords', $params);
	}
	
	public function movie_releases($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/releases', $params);
	}

	public function movie_trailers($id, $language = NULL, $append = NULL)
	{
		$params = array(
			'language'		=> $language,
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/trailers', $params);
	}
	
	public function movie_translations($id, $language = NULL, $append = NULL)
	{
		$params = array(
			'language'		=> $language,
			'append_to_response'	=> $append
		);
		
		return $this->_call('movie/' . $id . '/translations', $params);
	}
	
	public function movie_similar($id, $page = 1, $language = NULL, $append = NULL)
	{
		$params = array(
			'page'			=> $page,
			'language'		=> $language,
			'append_to_response'	=> $params
		);
		
		return $this->_call('movie/' . $id . '/similar_movies', $params);
	}
	
/////////////////////////////////////////////////////////////////////////////////////
	
	/********************************
	 *		  	 People		 		*
	 ********************************/
	 
	public function person_info($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('person/' . $id, $params);
	}
	
	public function person_credits($id, $language = NULL, $append = NULL)
	{
		$params = array(
			'language'		=> $language,
			'append_to_response'	=> $append
		);
		
		return $this->_call('person/' . $id . '/credits', $params);
	}
	
	public function person_images($id)
	{
		return $this->_call('person/' . $id . '/images');
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////
	
	/********************************
	 *		  	 Companies	 		*
	 ********************************/
	 
	public function company_info($id, $append = NULL)
	{
		$params = array(
			'append_to_response'	=> $append
		);
		
		return $this->_call('company/' . $id, $params);
	}
	
	public function company_movies($id, $page = 1, $language = NULL, $append = NULL)
	{
		$params = array(
			'page'			=> $page,
			'language'		=> $language,
			'append_to_response'	=> $params
		);
		
		return $this->_call('company/' . $id . '/movies', $params);
	}
	
/////////////////////////////////////////////////////////////////////////////////////
	
	/********************************
	 *		   	   Misc			 	*
	 ********************************/
	
	public function configuration()
	{
		return $this->_call('configuration');
	}
	
	public function latest_movie()
	{
		return $this->_call('latest/movie');
	}

	public function now_playing($page = 1, $language = NULL)
	{
		$params = array(
			'page'		=> $page,
			'language'	=> $language
		);
		
		return $this->_call('movie/now-playing', $params);
	}
	
	public function popular_movies($page = 1, $language = NULL)
	{
		$params = array(
			'page'		=> $page,
			'language'	=> $language
		);
		
		return $this->_call('movie/popular', $params);
	}
	
	public function top_rated($page = 1, $language = NULL)
	{
		$params = array(
			'page'		=> $page,
			'language'	=> $language
		);
		
		return $this->_call('movie/top-rated', $params);
	}
	
/////////////////////////////////////////////////////////////////////////////////////
	
	/********************************
	 * 		Private functions 		*
	 ********************************/
	
	private function _call($method, $params = NULL)
	{
		// Build the query string
		$params['api_key']	= $this->_api_key;
		//$params['language']	= $this->_language;
		$query_string = '?' . http_build_query($params);
		
		// Use cURL to call API and receive response
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->_api_url.$method.$query_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);

		curl_close ($ch);

		if ($info['http_code'] != 200)
			return FALSE;
		
		$response = json_decode($response); // Decode the JSON response into an array
		
		return $response; // Return the array
	}
}
