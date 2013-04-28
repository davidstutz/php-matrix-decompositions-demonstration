<?php
/**
 * I18n for Slim
 *
 * @author      David Stutz
 * @copyright   2012 David Stutz
 * @package		I18n
 * @license		http://en.wikipedia.org/wiki/MIT_License
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 
namespace Slim;
 
/**
 * I18n
 *
 * Internationalization class. Allows to set a language.
 * For translation the __() method is used (see below class).
 *
 * @author  David Stutz
 * @package	I18n
 */
class I18n {
    /**
	 * @var current language
	 */
	protected static $lang = 'en-us';
	 
	 /**
	  * @var path to language files
	  */
	 protected static $path = 'Lang';
	 
	 /**
	  * @var cache
	  */
	 protected static $cache = NULL;
	 
	 /**
	  * Set path
	  * @param	string	path
	  */
	 public static function setPath($path) {
	 	self::$path = $path;
	 }
	 
	 /**
	  * Get path
	  * @return	string	path
	  */
	 public static function getPath($path) {
	 	return self::$path;
	 }
	 
	 /**
	  * Get language
	  * @return	string	language
	  */
	 public static function getLang() {
	 	return $lang;
	 }
	 
	 /**
	  * Set language
	  * 
	  * This method will set the currently used language.
	  * The language code sonsists of the ISO 639-1 language code and the
	  * ISO 3166-1 alpha-2 country code separated by a '-'.
	  * 
	  * USAGE
	  * 
	  * Slim_I18n::setLang('en-us'); // en = language, us = country
	  * 
	  * @param	string	language
	  */
	 public static function setLang($lang) {
	 	$this->lang = $lang;
	 }
	 
	 /**
	  * Get translation
	  * @param	string	key
	  */
	 public static function getTranslation($key) {
	 	if ( is_null(self::$cache) ) {
	 		self::load(self::$lang);
	 	}
		
		return isset(self::$cache[$key]) ? self::$cache[$key] : $key;
	 }
	 
	 /**
	  * Set translation
	  * 
	  * Allows to dynamically set translations.
	  * If a translation for given key already exists it is overwritten.
	  * @param	string	key
	  * @param	string	translation
	  */
	 public static function setTranslation($key, $string) {
	 	if ( is_null(self::$cache) ) {
	 		self::load(self::$lang);
	 	}
		
		self::$cache[$key] = $string;
	 }
	 
	 /**
	  * Load translation file
	  */
	 protected static function load() {
	 	$codes = explode('-', self::$lang);
		
		$langFile = self::$path . DIRECTORY_SEPARATOR . $codes[0] . DIRECTORY_SEPARATOR . $codes[1] . '.php';
		
		if ( file_exists($langFile) ) {
			self::$cache = include $langFile;
		}
	 }
	 
	 /**
	  * Get translation table
	  * @return	array 	translation table
	  */
	 public static function translationTable() {
	 	if ( is_null(self::$cache) ) {
	 		self::load(self::$lang);
	 	}
		
		return self::$cache;
	 }
}