<?php
/**
 * ThiEngine
 *
 * @package ThiEngine - text highlighter
 * @version 0.0.1-alpha
 * @author jinpu <http://will-co21.net>
 * @lisence The LGPL License
 * @copyright Copyright 2012 jinpu. All rights reserved.
 */

/**
 * The ThiEngineEnv Class.
 */
class ThiEngineEnv {

	var $PARSERS_PATH;
	var $LOGFILE_PATH;
	
	var $LINE_NUMBERS_NORMAL;
	var $LINE_NUMBERS_FANCY;
	var $LINE_NUMBERS_NO;
	
	var $BLOCK_TYPE;
	var $BLOCK_STYLE;
	var $BLOCK_CLASS;
	var $BLOCK_VALUE;
	
	var $STRING_OPEN;
	var $STRING_CLOSE;
	var $STRING_ESCAPE;
	var $STRING_REG_OPEN;
	var $STRING_REG_CLOSE;
	
	var $COMMENT_MULTI_OPEN;
	var $COMMENT_MULTI_CLOSE;
	var $COMMENT_MULTI_NESTED;

	var $OTHER_BLOCK;
	
	var $BLOCK_TYPE_SCRIPT_OPEN;
	var $BLOCK_TYPE_STRING_OPEN;
	var $BLOCK_TYPE_STRING;
	var $BLOCK_TYPE_STRING_CLOSE;
	var $BLOCK_TYPE_COMMENT_MULTI;
	var $BLOCK_TYPE_COMMENT_MULTI_OPEN;
	var $BLOCK_TYPE_COMMENT_MULTI_BODY;
	var $BLOCK_TYPE_COMMENT_MULTI_CLOSE;
	var $BLOCK_TYPE_COMMENT_SINGLE;
	var $BLOCK_TYPE_COMMENT_SINGLE_START;
	var $BLOCK_TYPE_COMMENT_SINGLE_BODY;
	
	var $BLOCK_TYPE_IDENTIFIER;
	var $BLOCK_TYPE_KEYWORD;
	var $BLOCK_TYPE_SYMBOL;
	var $BLOCK_TYPE_NUMBER;
	var $BLOCK_TYPE_OBJECT_SPLITTER;
	var $BLOCK_TYPE_OBJECT_MEMBER;
	var $BLOCK_TYPE_CODE_BLANK;
	
	function ThiEngineEnv()
	{
		$this->PARSERS_PATH = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'language';
		$this->LOGFILE_PATH = dirname(__FILE__);
		
		$this->LINE_NUMBERS_NO = 0;
		$this->LINE_NUMBERS_NORMAL = 1;
		$this->LINE_NUMBERS_FANCY = 2;

		$this->BLOCK_TYPE = 0;
		$this->BLOCK_STYLE = 1;
		$this->BLOCK_CLASS = 2;
		$this->BLOCK_VALUE = 3;
		
		
		$this->STRING_OPEN = 0;
		$this->STRING_CLOSE = 1;
		$this->STRING_ESCAPE = 2;
		$this->STRING_OPEN_REG = 3;
		$this->STRING_CLOSE_REG = 4;

		$this->COMMENT_MULTI_OPEN = 0;
		$this->COMMENT_MULTI_CLOSE = 1;
		$this->COMMENT_MULTI_NESTED = 2;

		$this->BLOCK_TYPE_SCRIPT_OPEN = 0;
		$this->BLOCK_TYPE_SCRIPT_CLOSE = 1;
		
		$this->BLOCK_TYPE_STRING = 2;
		$this->BLOCK_TYPE_STRING_OPEN = 3;
		$this->BLOCK_TYPE_STRING_CLOSE = 4;
		
		$this->BLOCK_TYPE_COMMENT_SINGLE = 5;
		$this->BLOCK_TYPE_COMMENT_SINGLE_START = 6;
		$this->BLOCK_TYPE_COMMENT_SINGLE_BODY = 7;
		
		$this->BLOCK_TYPE_COMMENT_MULTI = 8;
		$this->BLOCK_TYPE_COMMENT_MULTI_OPEN = 9;
		$this->BLOCK_TYPE_COMMENT_MULTI_BODY = 10;
		$this->BLOCK_TYPE_COMMENT_MULTI_CLOSE = 11;
		
		$this->BLOCK_TYPE_OTHER_BLOCK = 12;
		
		$this->BLOCK_TYPE_KEYWORD = 13;
		$this->BLOCK_TYPE_IDENTIFIER = 14;
		
		$this->BLOCK_TYPE_SYMBOL = 15;
		$this->BLOCK_TYPE_NUMBER = 16;
		
		$this->BLOCK_TYPE_OBJECT_SPLITTER = 17;
		$this->BLOCK_TYPE_OBJECT_MEMBER = 18;
		
		$this->BLOCK_TYPE_CODE_BLANK = 19;
		$this->set_debug_mode();
	}
	
	function set_debug_mode()
	{
		$this->BLOCK_TYPE = "TYPE";
		$this->BLOCK_STYLE = "STYLE";
		$this->BLOCK_CLASS = "CLASS";
		$this->BLOCK_VALUE = "VALUE";
		
		$this->BLOCK_TYPE_SCRIPT_OPEN = "SCRIPT_OPEN";
		$this->BLOCK_TYPE_SCRIPT_CLOSE = "SCRIPT_CLOSE";
		
		$this->BLOCK_TYPE_STRING = "STRING";
		$this->BLOCK_TYPE_STRING_OPEN = "STRING_OPEN";
		$this->BLOCK_TYPE_STRING_CLOSE = "STRING_CLOSE";
		
		$this->BLOCK_TYPE_COMMENT_SINGLE = "COMMENT_SINGLE";
		$this->BLOCK_TYPE_COMMENT_SINGLE_START = "COMMENT_SINGLE_START";
		$this->BLOCK_TYPE_COMMENT_SINGLE_BODY = "COMMENT_SINGLE_BODY";
		
		$this->BLOCK_TYPE_COMMENT_MULTI = "COMMENT_MULTI";
		$this->BLOCK_TYPE_COMMENT_MULTI_OPEN = "COMMENT_MULTI_OPEN";
		$this->BLOCK_TYPE_COMMENT_MULTI_BODY = "COMMENT_MULTI_BODY";
		$this->BLOCK_TYPE_COMMENT_MULTI_CLOSE = "COMMENT_MULTI_CLOSE";
		
		$this->BLOCK_TYPE_OTHER_BLOCK = "OTHER_BLOCK";
		
		$this->BLOCK_TYPE_KEYWORD = "KEYWORD";
		$this->BLOCK_TYPE_IDENTIFIER = "IDENTIFIER";
		
		$this->BLOCK_TYPE_SYMBOL = "SYMBOL";
		$this->BLOCK_TYPE_NUMBER = "NUMBER";
		
		$this->BLOCK_TYPE_OBJECT_SPLITTER = "OBJECT_SPLITTER";
		$this->BLOCK_TYPE_OBJECT_MEMBER = "OBJECT_MEMBER";
		
		$this->BLOCK_TYPE_CODE_BLANK = "CODE_BLANK";
	}
	
	/**
	 * get instance
	 *
	 */
	function getInstance()
	{
		static $instance;
		
		if(!isset($instance))
		{
			$instance = new ThiEngineEnv();
			return $instance;
		}
		
		return $instance;
	}
}
/**
 * The ThiEngine Class.
 */
class ThiEngine {

	var $_parser;
	var $_renderer;
	var $_langname;

	function ThiEngine($text, $langname)
	{
		$langpath = ThiEngineEnv::getInstance()->PARSERS_PATH;
		$this->_langname = str_replace("-", "_", strtolower($langname));
		
		$langpath .= DIRECTORY_SEPARATOR . $this->_langname . '.lang.php';
		
		if(!file_exists($langpath))
		{
			return false;//後でエラー処理を追加する
		}
		require_once($langpath);
		
		$class = 'ThiEngineParser_' . strtoupper($langname);
		
		if(!class_exists($class))
		{
			return false;//後でエラー処理を追加する
		}

		$this->_parser = new $class($text);
		$this->_renderer = new ThiEngineRenderer($text, $this->_parser);
		
		if($this->_renderer->load_renderer($langname) == false)
		{
			return false;
		}
		
		return true;
	}
	
	function append_log($text, $file, $line)
	{
		$logfile = ThiEngineEnv::getInstance()->LOGFILE_PATH;
		
		if(!empty($logfile))
		{
			$logfile .= DIRECTORY_SEPARATOR;
		}
		
		$logfile .= "log.txt";
		$datetime = date('Y/m/d H:i:s');
		
		file_put_contents($logfile, "{$datetime}\n", FILE_APPEND);
		file_put_contents($logfile,'FILE: ' . $file, FILE_APPEND);
		file_put_contents($logfile,' LINE: ' . $line, FILE_APPEND);
		file_put_contents($logfile, "\n", FILE_APPEND);
		file_put_contents($logfile, $text, FILE_APPEND);
		file_put_contents($logfile, "\n", FILE_APPEND);
	}

	function parse()
	{
		return $this->_parser->parse();
	}
}
class ThiEngineRenderer {
	
	var $_line_numbers;
	var $_line_nth_row;
    var $_lexic_permissions;
	var $_line_style1;
	var $_code_style;
	var $_line_number_width;
	var $_tag_class;
	
	var $_env;
	var $_parser;
	var $_renderer;
	var $_langname;
	var $_block_count;
	var $_cur_block_num;
	var $_line_count;
	var $_pos_on_disp;
	
	function ThiEngineRenderer($text, $parser)
	{
		$this->_line_style1 = 'font-family: \'Courier New\', Courier, monospace; color: black; font-weight: normal; font-style: normal;';
		$this->_code_style = 'font-family: \'Courier New\', Courier, monospace; font-weight: normal;';
		$this->_line_number_width = 1;
		
		$this->lexic_permissions = array(
			$this->_env->BLOCK_TYPE_STRING => true,
			$this->_env->BLOCK_TYPE_COMMENT_SINGLE => true,
			$this->_env->BLOCK_TYPE_COMMENT_MULTI => true,
			$this->_env->BLOCK_TYPE_IDENTIFIER => true,
			$this->_env->BLOCK_TYPE_KEYWORD => true,
			$this->_env->BLOCK_TYPE_SYMBOL => true,
			$this->_env->BLOCK_TYPE_NUMBER => true,
			$this->_env->BLOCK_TYPE_OBJECT_SPLITTER => true,
			$this->_env->BLOCK_TYPE_OBJECT_MEMBER => true,
			$this->_env->BLOCK_TYPE_CODE_BLANK => true
	    );
		
		$this->_tag_class = "code";
		$this->_parser = $parser;	
		$this->_env = ThiEngineEnv::getInstance();
	}
	
	function load_renderer($langname, $renderer = null)
	{
		$this->_langname = str_replace("_", "-", strtolower($langname));
		
		if(empty($langname))
		{
			return false;
		}
		
		if($renderer == null)
		{
			$langclass_suffix = str_replace("-", "_", strtoupper($langname));
			
			if(isset($langname))
			{
				$renderer = "ThiEngineRenderer_{$langclass_suffix}";
			}
			else
			{
				$renderer = "ThiEngineRenderer";
			}
			
			if(!class_exists($renderer))
			{
				return false;//後でエラー処理を追加する
			}
	
			$this->_renderer = new $renderer($text, $langname);
		}
		else
		{
			if(!class_exists($renderer))
			{
				return false;//後でエラー処理を追加する
			}
	
			$this->_renderer = new $renderer($text, $langname);
		}
		
		return true;
	}
	
	function rend($blocks, $text)
	{
		if(empty($text) || !is_array($blocks) || (count($blocks) == 0))
		{
			return false;
		}
		
		$this->_line_count = 1;
		$this->reset_pos_on_display( __LINE__ );
		$this->_cur_block_num = 0;
		$this->_block_count = count($blocks);
		
		$line_count = count($text); 
		$this->_line_number_width = (strlen("{$line_count}") + 2); 
		
		return $this->rend_has_linenumber($blocks);
	}
	
	function rend_has_linenumber($blocks)
	{
		$listyle = $this->_line_style1;
		$class = "{$this->_tag_class}-{$this->_langname}";
		$result = "<div class={$class}>\n";
		
		$attr = "class=\"{$class}-de1\" style=\"$listyle\"";
		
		$line_number = $this->get_line_number_string($this->_line_count);
		$result .= "<div class=\"{$class}-li1\"><span class=\"{$class}-line-number\" style=\"width: {$this->_line_number_width}em;\">{$line_number}.&nbsp;</span>";
		foreach($blocks as $block)
		{
			$value = $block[$this->_env->BLOCK_VALUE];
			$style_num = $block[$this->_env->BLOCK_STYLE];
			
			switch($block[$this->_env->BLOCK_TYPE])
			{
				case $this->_env->BLOCK_TYPE_SCRIPT_OPEN:
				case $this->_env->BLOCK_TYPE_SCRIPT_CLOSE:
					$style = $this->_parser->STYLES["SCRIPT_TAG"][$style_num];
					$class_val = "{$class}-script-tag{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
					
				case $this->_env->BLOCK_TYPE_STRING_OPEN:
					$style = $this->_parser->STYLES["STRING_START"][$style_num];
					$class_val = "{$class}-string-open{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;

				case $this->_env->BLOCK_TYPE_STRING:
					$delimiters = $this->_parser->STRING_DELIMITERS[$style_num];
					//エスケープ文字を取り出し
					$style = $this->_parser->STYLES["STRING"][$style_num];
					$class_val = "{$class}-string-body{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val, $style_num);
					break;

				case $this->_env->BLOCK_TYPE_STRING_CLOSE:
					$style = $this->_parser->STYLES["STRING_END"][$style_num];
					$class_val = "{$class}-string-close{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;

				case $this->_env->BLOCK_TYPE_COMMENT_SINGLE_START:
				case $this->_env->BLOCK_TYPE_COMMENT_SINGLE_BODY:
					$style = $this->_parser->STYLES["COMMENT_SINGLE"][$style_num];
					$class_val = "{$class}-comment-single{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
					
				case $this->_env->BLOCK_TYPE_COMMENT_MULTI_OPEN:
				case $this->_env->BLOCK_TYPE_COMMENT_MULTI_BODY:
				case $this->_env->BLOCK_TYPE_COMMENT_MULTI_CLOSE:
					$style = $this->_parser->STYLES["COMMENT_MULTI"][$style_num];
					$class_val = "{$class}-comment-multi{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
				
				case $this->_env->BLOCK_TYPE_KEYWORD:
					$style = $this->_parser->STYLES["KEYWORD"][$style_num];
					$class_val = "{$class}-keyword{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
				
				case $this->_env->BLOCK_TYPE_IDENTIFIER:
					$style = $this->_parser->STYLES["IDENTIFIER"][$style_num];
					$class_val = "{$class}-identifier{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
				
				case $this->_env->BLOCK_TYPE_SYMBOL:
					$style = $this->_parser->STYLES["SYMBOL"][$style_num];
					$class_val = "{$class}-symbol{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
				
				case $this->_env->BLOCK_TYPE_NUMBER:
					$style = $this->_parser->STYLES["NUMBER"][$style_num];
					$class_val = "{$class}-number{$style_num}";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
					
				case $this->_env->BLOCK_TYPE_OBJECT_SPLITTER:
					$style = $this->_parser->STYLES["OBJECT_SPLITTER"];
					$class_val = "{$class}-object-splitter";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;
				
				case $this->_env->BLOCK_TYPE_OBJECT_MEMBER:
					$style = $this->_parser->STYLES["OBJECT_MEMBER"];
					$class_val = "{$class}-object-member";
					$result .= $this->rend_block($value, $class, $style, $class_val);
					break;

				default:
					$result .= $this->rend_other_block($value, $class);
			}
			$this->_cur_block_num++;
		}
		
		return "{$result}</div>";
	}
	
	function rend_block($block, $class, $style = "", $tagclass = "", $escnum = null)
	{
		$result = "";
		$value = "";
		$pos = false;
		$i = 0;
		
		$tag = "";
		
		if(!empty($style) || !empty($tagclass))
		{
			$style = (!empty($style)) ? " style=\"{$style}\"" : "";
			$tagclass = (!empty($tagclass)) ? " class=\"{$tagclass}\"" : "";
			
			$tag = "<span{$style}{$tagclass}>";
			$result .= $tag;
		}
		
		if(isset($escnum))
		{
			$delimiters = $this->_parser->STRING_DELIMITERS[$escnum];
			$esc = isset($delimiters[$this->_env->STRING_ESCAPE]) ? $delimiters[$this->_env->STRING_ESCAPE] : null;
			$esc_style = $this->_parser->STYLES["ESCAPE_CHAR"][$escnum];
			$esc_class = "{$class}-string-esc{$escnum}";
			$esc_style = (!empty($esc_style)) ? " style=\"{$esc_style}\"" : "";
			$esc_class = (!empty($esc_class)) ? " class=\"{$esc_class}\"" : "";
			
			$esctag = "<span{$esc_style}{$esc_class}>";
		}
		
		
		while(($pos = strpos($block, "\n", $i)) !== false)
		{
			$hscstr = "";
			$this->_line_count++;
			$this->reset_pos_on_display( __LINE__ );
			
			if($pos > 0)
			{
				if(isset($esc))
				{
					while( (($escpos = strpos($block, $esc, $i)) !== false) &&
						   (($escpos < $pos)) ) 
					{
						if(($escpos + strlen($esc)) == strlen($block))
						{
							break;
						}
						
						if(strpos($block, $esc, $escpos + strlen($esc)) === 0)
						{
							$value = substr($block, $escpos, $escpos - $i);
							$result .= $this->hsc($value);
							$result .= "</span>{$esctag}";
							
							$value = substr($block, $escpos, strlen($esc) * 2);
							$value = $this->hsc($value);
							$result .= "{$value}</span>{$tag}";
							$i = $escpos + strlen($esc) * 2;
						}
						else
						{
							$value = substr($block, $escpos, $escpos - $i);
							$result .= $this->hsc($value);
							$result .= "</span>{$esctag}";
							
							$value = substr($block, $escpos, strlen($esc) + 1);
							$value = $this->hsc($value);
							$result .= "{$value}</span>{$tag}";
							$i = $escpos + strlen($esc) + 1;
						}
					}
				}
				
				$value = substr($block, $i, $pos - $i);
				
				$i = $pos + 1;
				
				$hscstr = $this->hsc($value);
			}
			else
			{
				if(strpos($block, "\n", $i) === false)
				{
					$i = strlen($block);
				}
				else
				{
					$i = $pos + 1;
				}
			}
			$result .= "{$hscstr}</div>\n";
			$listyle = $this->line_style1;
			$class = "{$this->_tag_class}-{$this->_langname}";
			
			$attr = "class=\"{$class}-de1\" style=\"$listyle\"";

			$line_number = $this->get_line_number_string($this->_line_count);
			$result .= "<div class=\"{$class}-li1\" style=\"><span class=\"{$class}-line-number\" style=\"width: {$this->_line_number_width}em;\">{$line_number}.&nbsp;</span>{$tag}";
		}
		
		if($pos === false)
		{
			if( (isset($esc)) && ($i < strlen($block) - 1) )
			{
				while(($escpos = strpos($block, $esc, $i)) !== false)
				{
					if(($escpos + strlen($esc)) == (strlen($block)))
					{
						break;
					}
					
					if(strpos($block, $esc, $escpos + strlen($esc)) === 0)
					{
						$value = substr($block, $i, $escpos - $i);
						$result .= $this->hsc($value);
						$result .= "</span>{$esctag}";
						
						$value = substr($block, $escpos, strlen($esc) * 2);
						$value = $this->hsc($value);
						$result .= "{$value}</span>{$tag}";
						$i = $escpos + strlen($esc) * 2;
					}
					else
					{
						$value = substr($block, $i, $escpos - $i);
						$result .= $this->hsc($value);
						$result .= "</span>{$esctag}";
						
						$value = substr($block, $escpos, strlen($esc) + 1);
						$value = $this->hsc($value);
						$result .= "{$value}</span>{$tag}";
						$i = $escpos + strlen($esc) + 1;
					}
				}
			}
			
			$hscstr = $this->hsc(substr($block, $i));
			
			if($this->_cur_block_num == ($this->_block_count - 1))
			{
				$this->add_pos_on_display(strlen($block) - $i, __LINE__);
				
				if(!empty($tag))
				{
					$result .= "{$hscstr}</span></div>\n";
				}
				else
				{
					$result .= "{$hscstr}</div>\n";
				}
			}
			else if(!empty($tag))
			{
				$result .= $hscstr;
				$result .= "</span>";
			}
			else
			{
				$result .= $hscstr;
			}
		}
		
		return $result;
	}
		
	function hsc($value, $pre_mode = false)
	{
		if(empty($value))
		{
			return $value;
		}
		
		$transchar = array(
			'&' => '&amp;',
			'"' => '&quot;',
			'<' => '&lt;',
			'>' => '&gt;',
			' ' => '&nbsp;'
		);
		
		if($pre_mode)
		{
			unset($transchar[' ']);
		}
		
		$result = "";
		
		$full_parts = $value;
		
		if(strpos($full_parts, "\t") === false)
		{
			$this->add_pos_on_display((strlen($value) - 1), __LINE__ );
			return strtr($value, $transchar);
		}
		
		while(($tabpos = strpos($full_parts, "\t")) !== false)
		{
			if($tabpos == 0)
			{
				if($full_parts == "\t")
				{
					$tab_width = $this->_parser->TAB_WIDTH;
					$tab_width = $this->_pos_on_disp % $this->_parser->TAB_WIDTH;
					
					if($tab_width == 0)
					{
						$tab_width = $this->_parser->TAB_WIDTH;
					}
					
					$result .= $this->get_space_for_indent($tab_width);
					$this->add_pos_on_display($tab_width, __LINE__ );
					return $result;
				}
				else
				{
					$tab_width = $this->_parser->TAB_WIDTH;
					$tab_width = $this->_pos_on_disp % $this->_parser->TAB_WIDTH;
					
					if($tab_width == 0)
					{
						$tab_width = $this->_parser->TAB_WIDTH;
					}
					
					$result .= $this->get_space_for_indent($tab_width);
					
					$first_parts = $full_parts[0];
					$full_parts = substr($full_parts, 1, strlen($full_parts) - 1);
					$this->add_pos_on_display($tab_width, __LINE__ );
					
					continue;
				}
			}
			else
			{
				$first_parts = substr($full_parts, 0, $tabpos);
				
				$full_parts = substr(
					$full_parts, $tabpos, strlen($full_parts) - $tabpos);
				$this->add_pos_on_display($tabpos, __LINE__ );
			}
			
			$tab_width = $this->_parser->TAB_WIDTH;
			$tab_width = $this->_pos_on_disp % $this->_parser->TAB_WIDTH;
			
			if($tab_width == 0)
			{
				$tab_width = $this->_parser->TAB_WIDTH;
			}
			
			$first_parts = $this->hsc($first_parts);
			$result .= $first_parts;
			$first_parts = "";
			$result .= $this->get_space_for_indent($tab_width);
			$this->add_pos_on_display($tab_width, __LINE__ );
		}
		
		if(!empty($full_parts))
		{
			$full_parts = $this->hsc($full_parts);
			$result .= $full_parts;
		}
		
		return $result;
	}
	
	function rend_other_block($block, $class)
	{
		$result .= $this->rend_block($block, $class);
		return $result;
	}
	
	function append_log($text, $file, $line)
	{
		ThiEngine::append_log($text, $file, $line);
	}
	
	function add_pos_on_display($val, $line)
	{
		$this->_pos_on_disp += $val;
	}
	
	function reset_pos_on_display($line)
	{
		$this->_pos_on_disp = 0;
	}
	
	function get_line_number_string($number)
	{
		return str_replace(" ", "&nbsp;", 
			sprintf("%{$this->_line_number_width}d", $number));
	}
	
	function get_space_for_indent($tab_width, $pre_mode = false)
	{
		if($pre_mode)
		{
			return str_repeat(" ", $tab_width);
		}
		else
		{
			return str_repeat("&nbsp;", $tab_width);
		}
	}
}
class ThiEngineParser {

	var $_strict_mode;
	var $_env;
	
	var $_src;
	var $_pos;
	var $_count;
	
	var $_blocks;
	var $_block_count;
	
	var $_keywords_reg;
	var $_keywords_dic;
	var $_last_keyword_next_pos;
	var $_symbols_reg;
	
	//スクリプト開始タグ
	var $SCRIPT_DELIMITERS;
	//文字列デリミタ
	var $STRING_DELIMITERS;
	//複数行コメントデリミタ
	var $COMMENT_MULTI;
	//一行コメント開始記号
	var $COMMENT_SINGLE;

	var $NAME_SYMBOLE_PTTREN;
	
	//キーワードグループのリスト
	var $KEYWORDS;
	
	//シンボルのリスト
	var $SYMBOLS;
	
	//スタイルのリスト。キーワードやシンボルなどがそれぞれのグループごとに定義されている。
	var $STYLES;
	
	//キーワードを強制的に小文字 or 大文字に変換する、もしくはそのままの設定
	var $CASE_KEYWORDS;
	
	//キーワードグループごとに大文字/小文字の区別の有無。
	//コメントに対しても一つだけ定義可能
	var $CASE_SENSITIVE;
	
	//オブジェクト（インスタンスおよびクラス）のデリミタ
	var $OBJECT_SPLITTERS;
	
	//オブジェクトメンバの正規表現パターン
	var $MEMBER_IDENTIFIER;
	
	//その他の識別子の正規表現パターン
	var $OTHER_IDENTIFIER;
	
	//スクリプトタグの中のみハイライトするモードの切り替えをユーザ側で行えるか
	//(strictモード)
	var $STRICT_MODE_APPLIES;
	
	//スクリプトタグ種別ごとのハイライトの切り替え(strictモードの指定より優先される)
	var $HIGHLIGHT_STRICT_BLOCK;
	
	//タブの幅
	var $TAB_WIDTH;
	
	function ThiEngineParser($src)
	{
		$this->_env = ThiEngineEnv::getInstance();
		$this->_line_numbers = $this->_env->LINE_NUMBERS_NO;
		$this->_strict_mode = false;
		$this->_src = $src;
		$this->_pos = 0;
		$this->_block_count = 0;
		$this->_keywords_dic = null;
		$this->_keywords_reg = null;
		$this->_last_keyword_next_pos = null;
		$this->_symbols_reg = null;
		
		$this->MEMBER_IDENTIFIER = null;
		
		$this->IDENTIFIERS = array(
			0 => '[_a-zA-Z][_a-zA-Z\d]*'
		);
		
		$this->OTHER_IDENTIFIER = '[_a-zA-Z][_a-zA-Z\d]*';
		
		$this->SYMBOLS = array(
			0 => array(
				'(', ')', '[', ']', '{', '}', '!', '@', '%', '&', '*', '|', '/', '<', '>'
    		)
		);
	}
	
	function enable_line_number($flag, $nth_row = 5)
	{
		if( ($flag != $this->_env->LINE_NUMBERS_NO) &&
		    ($flag != $this->_env->LINE_NUMBERS_NORMAL) &&
			($flag != $this->_env->LINE_NUMBERS_FANCY) )
		{
			return;//後でエラー処理を追加する
		}
		
		$this->_line_numbers = $flag;
		$this->_line_nth_row = $nth_row;
	}
	
	function parse()
	{	
		//改行を\nに統一
		$this->_src = str_replace(array("\r\n", "\n"), "\n", $this->_src);
		$this->_count = strlen($this->_src);
		$this->_blocks = array();
		$this->parse_all_section();
		
		return $this->_blocks;
	}

	function parse_all_section()
	{
		for($i = $this->_pos; $i < $this->_count ; /* void */)
		{
			$index = $i;
			
			if(!$this->_strict_mode)
			{
				$i = $this->parse_code_section($i);
				
				if($i >= $this->_count)
				{
					return;
				}
				
				if($i == $index)
				{
					$i++;
				}
				
				continue;
			}
			
			$i = $this->parse_raw_section($i);

			if($i == $index)
			{
				$i++;
			}
		}
		
		if($i > $this->_pos)
		{
			//otherブロックを追加
			$i = $this->add_other_block($i, __LINE__ );
		}
		
		return $i;
	}
	
	function parse_raw_section($index)
	{
		for($i = $index; $i < $this->_count ; /* void */)
		{
			$index = $i;
			//スクリプト開始タグと終了タグの組み合わせを全て取り出す
			foreach($this->SCRIPT_DELIMITERS as $key => $delimiters)
			{
				//スクリプト開始タグと終了タグを取り出し
				foreach($delimiters as $open => $close)
				{
					break;
				}
				
				//スクリプト開始タグを検出
				if (strpos($this->_src, $open, $i) === $i)
				{
					if($i > $this->_pos)
					{
						//otherブロックを追加してスクリプト開始タグ開始
						$i = $this->add_other_block($i, __LINE__ );
					}
					
					//スクリプト開始タグ部分をブロックに追加してタグの直後へ
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_SCRIPT_OPEN,
							$this->_env->BLOCK_STYLE => $key,
							$this->_env->BLOCK_CLASS => $key,
							$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, strlen($open))
						)
						, __LINE__
					);
					
					$this->_pos += strlen($open);
					$i = $this->_pos;
					$i = $this->parse_code_section($i, $key, $close);
					
					if($i == $index)
					{
						$i++;
					}
					
					//スクリプト終了タグかテキストの終わりを検出したら continue 2;
					$index = $i;
					
					continue 2;
				}
			}
			
			if($i == $index)
			{
				$i++;
			}
		}
		
		if($i > $this->_pos)
		{
			//otherブロックを追加
			$i = $this->add_other_block($i, __LINE__ );
		}
		
		return $i;
	}
	
	function parse_code_section($index, $delim_num = 0, $closetag = null)
	{
		for($i = $index; $i < $this->_count; /* void */)
		{	
			$index = $i;
			if(($this->_strict_mode) && 
				($this->parse_isend_script($i, $closetag)))
			{
				//スクリプト終了タグを検出
				if (strpos($this->_src, $closetag, $i) === $i)
				{
					if($i > $this->_pos)
					{
						//otherブロックを追加してスクリプト終了タグ開始
						$i = $this->add_other_block($i, __LINE__ );
					}

					//スクリプト終了タグ部分をブロックに追加してタグの直後へ
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_SCRIPT_CLOSE,
							$this->_env->BLOCK_STYLE => $delim_num,
							$this->_env->BLOCK_CLASS => $delim_num,
							$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, strlen($closetag))
						)
						, __LINE__
					);
					
					$this->_pos += strlen($closetag);
					
					return $this->_pos;
				}
			}
			
			$i = $this->parse_string_section($i);
			
			if($i > $index)
			{
				continue;
			}
			
			$i = $this->parse_multi_comment_section($i);

			if($i > $index)
			{
				continue;
			}
			
			$i = $this->parse_single_comment_section($i);

			if($i > $index)
			{
				continue;
			}
			
			$i = $this->parse_code_body($i, $closetag);

			if(($i == $index) && ($this->parse_isend_script($i, $closetag)))
			{
					if($i > $this->_pos)
					{
						//otherブロックを追加してスクリプト開始タグ開始
						$i = $this->add_other_block($i, __LINE__ );
					}
					
					//スクリプト開始タグ部分をブロックに追加してタグの直後へ
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_SCRIPT_OPEN,
							$this->_env->BLOCK_STYLE => $key,
							$this->_env->BLOCK_CLASS => $key,
							$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, strlen($open))
						)
						, __LINE__
					);
					
					$this->_pos += strlen($open);
					$i = $this->_pos;
			} 
			else if($i == $index)
			{
				$i++;
			}
		}
		
		if($i > $this->_count)
		{
			$i = $this->_count;
		}
		
		if(($i > $this->_pos) && ($i <= $this->_count))
		{
			//otherブロックを追加
			$i = $this->add_other_block($i, __LINE__ );
			$i++;
		}
		
		if($i > $this->_pos)
		{
			$this->_pos = $i;
		}
		
		return $this->_pos;
	}
	
	function parse_code_body($index, $closetag)
	{
		$i = $index;

		$end = false;
		$check_end = null;
		$start_blank = null;
		$other_start = null;
		$other_end = null;
		
		if($i > $this->_pos)
		{
			//otherブロックを追加
			
			$i = $this->add_other_block($i, __LINE__ );
		}
		
		while($i < $this->_count)
		{
			$c = $this->_src[$i];
			
			switch($c)
			{
				case " " :
				case "\t" :
				case "\n" :
				//何もない部分
					if($other_start < $other_end)
					{
						//otherブロックを追加
						$i = $this->add_other_block($i, __LINE__ );
						$other_start = null;
						$other_end = null;
					}
					
					if(!isset($start_blank))
					{
						$start_blank = $i;
					}
					
					$end = true;
					$check_end = null;
					$i++;
				break;
				
				default:
					
					if(!isset($other_start))
					{
						$other_start = $i;
						$other_end = $i;
					}
					
					if(isset($start_blank))
					{
						$this->add_block(array(
								$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_CODE_BLANK,
								$this->_env->BLOCK_STYLE => 0,
								$this->_env->BLOCK_CLASS => 0,
								$this->_env->BLOCK_VALUE => substr($this->_src, $start_blank, $i - $start_blank)
							)
							, __LINE__
						);
						$this->_pos = $i;
					}

					//※falseや0や空文字列ではなく、必ずnullを設定すること。
					$start_blank = null;
					
					//文字列 or 複数行コメント or 一行コメントの開始を判定
					if(($i > $index) && ($this->parse_isstart_string($i)))
					{
						return $i;
					}
					else if(($i > $index) && 
						($this->parse_isstart_multi_comment($i)))
					{
						return $i;
					}
					else if(($i > $index) && 
						($this->parse_isstart_single_comment($i)))
					{
						return $i;
					}
					else if(($i > $index) && (isset($closetag)))
					{
						//スクリプトブロックの終了を判定
						if($this->parse_isend_script($i, $closetag))
						{
							if($i > $this->_pos)
							{
								//otherブロックを追加
								$i = $this->add_other_block($i, __LINE__ );
							}
							return $i;
						}
					}
					
					if(!isset($check_end))
					{
						if(preg_match('/ |\t|\n/', 
							$this->_src, $match, PREG_OFFSET_CAPTURE, $i))
						{
							$check_end = $match[0][1];
						}
						else
						{
							$check_end = $this->_count;
						}
					}
					
					$check = substr($this->_src, $i, $check_end - $i);
					
					$index = $i;

					//空白でない文字列をパース
					$i = $this->parse_code_body_not_blank($i, $check);
					
					if($i == $index)
					{
						$i++;
						$other_end = $i;
					}
					else
					{
						$other_start = $i;
						$other_end = $i;
					}
					
					$end = false;
			}
		}

		if($i > $this->_pos)
		{
			//otherブロックを追加
			$i = $this->add_other_block($i, __LINE__ );
			$i++;
		}
		
		return $i;
	}
	
	function parse_code_body_not_blank($index, $check)
	{
		$i = $index;
		
		$i = $this->parse_object_member($i, $check);
		
		if($i > $index)
		{
			return $i;
		}
		
		if($i > $index)
		{
			return $i;
		}
		
		$index = $i;

		$i = $this->parse_code_keyword($i, $check);		
		
		$index = $i;
		
		$i = $this->parse_code_identifier($i, $check);
		
		if($i > $index)
		{
			return $i;
		}
		
		
		$index = $i;

		$i = $this->parse_symbol($i, $check);

		if($i > $index)
		{
			return $i;
		}
				
		$index = $i;

		$i = $this->parse_object_splitter($i, $check);
		
		if($i > $index)
		{
			return $i;
		}
				
		$i = $this->parse_number($i, $check);
		
		return $i;
	}
	
	function parse_number($index, &$check)
	{
		$i = $index;
		
		if(preg_match('/^\d+/', $check, $match))
		{
			if($i > $this->_pos)
			{
				//otherブロックを追加
				$i = $this->add_other_block($i, __LINE__ );
			}
			
			$value = $match[0];
			
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_NUMBER,
					$this->_env->BLOCK_STYLE => 0,
					$this->_env->BLOCK_CLASS => 0,
					$this->_env->BLOCK_VALUE => $value
				)
				, __LINE__
			);
			
			$i += strlen($value);
			$this->_pos = $i;
			
			if(strlen($check) > strlen($value))
			{
				$check = substr($check, strlen($value));
			}
			else
			{
				$check = "";
			}
			
			return $i;
		}
		
		return $i;
	}
	
	function parse_code_identifier($index, &$check)
	{
		$i = $index;

		if(empty($check))
		{
			return $i;
		}
		
		
		foreach($this->IDENTIFIERS as $key => $identifier)
		{
			$identifier = str_replace("/", "\\/", $identifier);
			//識別子判別用正規表現パターンを全部取り出す
			if(preg_match('/^' . $identifier . '/', $check, $match))
			{
				if($i > $this->_pos)
				{
					//otherブロックを追加
					$i = $this->add_other_block($i, __LINE__ );
				}
				
				$word = $match[0];
				
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_IDENTIFIER,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						$this->_env->BLOCK_VALUE => $word
					)
					, __LINE__
				);
				
				$i += strlen($word);
				$this->_pos = $i;
				
				if(strlen($check) > strlen($word))
				{
					$check = substr($check, strlen($word));
				}
				else
				{
					$check = "";
				}
				return $i;
			}
		}
		return $i;
	}
	
	function quote_chars($word)
	{
		return preg_quote($word, '/');
	}
		
	function parse_code_keyword($index, &$check)
	{
		$i = $index;

		if(empty($check))
		{
			return $i;
		}

		if(!isset($this->_keywords_reg))
		{
			$this->_keywords_reg = array();
			$regexp = "";
			
			//キーワードを全部取り出す
			foreach($this->KEYWORDS as $key => $words)
			{
				$chars = join("", $words);
				preg_match_all('/./', $chars, $match);
				
				$chars = array_unique($match[0]);
				$regexp = "[";
				
				foreach($chars as $char)
				{
					$regexp .= preg_quote($char, "/");
				}
				
				$regexp .= "]+";
				$this->_keywords_reg[$key] = $regexp;
			}
		}

		if(!isset($this->_keywords_reg) || (count($this->_keywords_reg) == 0))
		{
			return $i;
		}
		
		if(!isset($this->_keywords_dic))
		{
			$this->_keywords_dic = array();
			
			foreach($this->KEYWORDS as $key => $words)
			{
				$this->_keywords_dic[$key] = array_flip($words);
			}
		}
		
		if(!isset($this->_keywords_dic) || (count($this->_keywords_dic) == 0))
		{
			return $i;
		}
		
		foreach($this->KEYWORDS as $key => $words)
		{
			$regexp = "/^{$this->_keywords_reg[$key]}/";
			
			if(preg_match($regexp, $check, $match))
			{
				$word = $match[0];
				$len =  strlen($word);
				$find = false;
				
				for($val = $word; $len > 1 ; $len--)
				{
					if(array_key_exists($val, $this->_keywords_dic[$key]))
					{
						$find = true;
						break;
					}
					
					$val = substr($val, 0, $len - 1);
				}
				
				$word = $val;
				
				if(!$find)
				{
					continue;
				}
				
				if($i > $this->_pos)
				{
					//otherブロックを追加
					$i = $this->add_other_block($i, __LINE__ );
				}
				
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_KEYWORD,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						$this->_env->BLOCK_VALUE => $word
					)
					, __LINE__
				);
				
				$i += strlen($word);
				$this->_pos = $i;
				
				if(strlen($check) > strlen($word))
				{
					$check = substr($check, strlen($word));
				}
				else
				{
					$check = "";
				}
				
				return $i;
			}
		}

		if(preg_match("/^{$this->OTHER_IDENTIFIER}/", $check, $match))
		{
			$check = substr($check, strlen($match[0]));
			$i += strlen($match[0]);
			//otherブロックを追加
			$i = $this->add_other_block($i, __LINE__ );
		}
		
		return $i;
	}
	
	function parse_object_splitter($index, &$check)
	{
		$i = $index;
		
		if(empty($check))
		{
			return $i;
		}
		
		//オブジェクトスプリッタを全部取り出す
		foreach($this->OBJECT_SPLITTERS as $key => $splitter)
		{
			$find = strpos($check, $splitter);
			
			if($find === 0)
			{
				if($i > $this->_pos)
				{
					//otherブロックを追加
					$i = $this->add_other_block($i, __LINE__ );
				}
				
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_OBJECT_SPLITTER,
						$this->_env->BLOCK_STYLE => 0,
						$this->_env->BLOCK_CLASS => 0,
						$this->_env->BLOCK_VALUE => $splitter
					)
					, __LINE__
				);
				
				$i += strlen($splitter);
				$this->_pos = $i;

				if(strlen($check) > strlen($splitter))
				{
					$check = substr($check, strlen($splitter));
				}
				else
				{
					$check = "";
				}
				
				return $i;
			}
		}
		
		return $i;
	}
	
	function parse_object_member($index, &$check)
	{
		$i = $index;
		
		if(!isset($this->MEMBER_IDENTIFIER))
		{
			return $i;
		}
		
		if($this->_block_count == 0)
		{
			return $i;
		}
		
		$isafter_obj_splitter = false;
		
		$before = $this->_blocks[$this->_block_count - 1];
		$object_member_key = $this->_env->BLOCK_TYPE_OBJECT_SPLITTER;
		$blank_key = $this->_env->BLOCK_TYPE_CODE_BLANK;
		
		if($before[$this->_env->BLOCK_TYPE] == $object_member_key)
		{
			$isafter_obj_splitter = true;
		}
		else if( ($this->_block_count > 1) && 
				 ($before[$this->_env->BLOCK_TYPE] == $blank_key) )
		{
			$blank_value = $before[$this->_env->BLOCK_VALUE];
			$before = $this->_blocks[$this->_block_count - 2];
			
			if( (!preg_match('/\n/', $blank_value)) && 
				($before[$this->_env->BLOCK_TYPE] == $object_member_key) )
			{
				$isafter_obj_splitter = true;
			}
		}

		$regexp = '/^' . str_replace("/", "\\/", $this->MEMBER_IDENTIFIER) . '/';
		if( ($isafter_obj_splitter) && (preg_match($regexp, $check, $match)) )
		{
			$word = $match[0];
			
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_OBJECT_MEMBER,
					$this->_env->BLOCK_STYLE => 0,
					$this->_env->BLOCK_CLASS => 0,
					$this->_env->BLOCK_VALUE => $word
				)
				, __LINE__
			);
			
			$i += strlen($word);
			$this->_pos = $i;
			
			if(strlen($check) > strlen($word))
			{
				$check = substr($check, strlen($word));
			}
			else
			{
				$check = "";
			}
		}
		
		return $i;
	}
	
	function parse_symbol($index, &$check)
	{	
		$i = $index;
		
		if(empty($check))
		{
			return $i;
		}
	
		//シンボルを全部取り出す
		foreach($this->SYMBOLS as $key => $symbols)
		{
			foreach($symbols as $symbol)
			{
				$find = strpos($check, $symbol);
				
				if($find === 0)
				{
					if($i > $this->_pos)
					{
						//otherブロックを追加
						$i = $this->add_other_block($i, __LINE__ );
					}
					
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_SYMBOL,
							$this->_env->BLOCK_STYLE => $key,
							$this->_env->BLOCK_CLASS => $key,
							$this->_env->BLOCK_VALUE => $symbol
						)
						, __LINE__
					);
					
					$i += strlen($symbol);
					$this->_pos = $i;

					if(strlen($check) > strlen($symbol))
					{
						$check = substr($check, strlen($symbol));
					}
					else
					{
						$check = "";
					}
					
					return $i;
				}
			}
		}
		
		return $i;
	}
	
	function parse_isend_script($index, $closetag)
	{
		//スクリプト終了タグを検出
		if (strpos($this->_src, $closetag, $index) === $index)
		{
			return true;
		}
		
		return false;
	}
	
	function parse_isstart_string($index)
	{
		$i = $index;
		//文字列開始シークエンスと終了シークエンスの組み合わせを全部取り出す
		foreach($this->STRING_DELIMITERS as $key => $delimiters)
		{
			//文字列開始シークエンスと終了シークエンスを取り出し
			$open = $delimiters[$this->_env->STRING_OPEN];
			$close = $delimiters[$this->_env->STRING_CLOSE];
			$open_reg = isset($delimiters[$this->_env->STRING_OPEN_REG]) ? $delimiters[$this->_env->STRING_OPEN_REG] : null;
			$open_reg = str_replace("/", "\\/", $open_reg);
						
			//文字列開始シークエンスを検出
			if (strpos($this->_src, $open, $i) === $i)
			{
				$check = substr($this->_src, $i + strlen($open));
				//文字列開始シークエンス部分をブロックに追加してその直後へ
				if(isset($open_reg))
				{
					//文字列開始シークエンス正規表現では、
					//サブパターン1と2を含み、サブパターン1は必ずパターンの先頭から書く。
					//また、サブパターン2はサブパターン1の内部に入れ、
					//必ずサブパターン1と開始位置を連続させる。((ptn~のように。
					//サブパターン1までが開始シークエンス、それ以降は文字列本体となる。
					//サブパターン2は終了シークエンスに使われる。
					
					$pos = $i + strlen($open);
					
					if( preg_match('/^' . $open_reg . '/s', $check, $match) )
					{
						return true;
					}
				}
				else
				{
					return true;
				}
			}
		}
		
		return false;
	}
	
	function parse_isstart_multi_comment($index)
	{
		$i = $index;
		//複数行コメント開始シークエンスと終了シークエンスの組み合わせを全部取り出す
		foreach($this->COMMENT_MULTI as $key => $delimiters)
		{
			//複数行コメント開始シークエンスと終了シークエンスを取り出し
			$open = $delimiters[$this->_env->COMMENT_MULTI_OPEN];
			$close = $delimiters[$this->_env->COMMENT_MULTI_CLOSE];
			$nesting = isset($delimiters[$this->_env->COMMENT_MULTI_NESTED]) ? $delimiters[$this->_env->COMMENT_MULTI_NESTED] : false;
			
			//複数行コメント開始シークエンスを検出
			
			if(strpos($this->_src, $open, $i) === $i)
			{
				return true;
			}
		}
		
		return false;
	}
	
	function parse_isstart_single_comment($index)
	{
		$i = $index;
		//一行コメント開始シークエンスを取り出し
		foreach($this->COMMENT_SINGLE as $key => $open)
		{
			//一行コメント開始シークエンスを検出
			if (strpos($this->_src, $open, $i) === $i)
			{
				return true;
			}
		}
		
		return false;
	}
	
	function parse_string_section($index)
	{
		$i = $index;
		
		//文字列開始シークエンスと終了シークエンスの組み合わせを全部取り出す
		foreach($this->STRING_DELIMITERS as $key => $delimiters)
		{
			//文字列開始シークエンスと終了シークエンスを取り出し
			$open = $delimiters[$this->_env->STRING_OPEN];
			$close = $delimiters[$this->_env->STRING_CLOSE];
			
			$open_reg = isset($delimiters[$this->_env->STRING_OPEN_REG]) ? $delimiters[$this->_env->STRING_OPEN_REG] : null;
			$open_reg = isset($open_reg) ? str_replace("/", "\\/", $open_reg) : null;
			
			$close_reg = isset($delimiters[$this->_env->STRING_CLOSE_REG]) ? $delimiters[$this->_env->STRING_CLOSE_REG] : null;
						
			//エスケープ文字を取り出し
			$esc = isset($delimiters[$this->_env->STRING_ESCAPE]) ? $delimiters[$this->_env->STRING_ESCAPE] : null;
			
			//文字列開始シークエンスを検出
			if(strpos($this->_src, $open, $i) === $i)
			{
				//文字列開始シークエンス部分をブロックに追加してその直後へ
				if(isset($open_reg))
				{
					//文字列開始シークエンス正規表現では、
					//サブパターン1と2を含み、サブパターン1は必ずパターンの先頭から書く。
					//また、サブパターン2はサブパターン1の内部に入れ、
					//必ずサブパターン1と開始位置を連続させる。((ptn~のように。
					//サブパターン1までが開始シークエンス、それ以降は文字列本体となる。
					//サブパターン2は終了シークエンスに使われる。
					if( preg_match('/^' . $open_reg . '/s', 
						substr($this->_src, $i + strlen($open)), $match) )
					{
						if($i > $this->_pos)
						{
							//otherブロックを追加して文字列開始シークエンス開始
							$i = $this->add_other_block($i, __LINE__ );
						}
						
						//文字列終了シークエンス正規表現では、/eom/の部分が開始シークエンスの
						//サブパターン2に置き換わる。
						// /eom/の部分以外の/は\/とエスケープして定義しておくこと。
						$close_reg = str_replace('/eom/', preg_quote($match[2], "/"), $close_reg);
						$value = substr($this->_src, $i, strlen($open));
						$this->_pos = $i;
					}
					else
					{
						//文字列開始シークエンス正規表現にマッチしなかった場合、continue;
						continue;
					}
				}
				else
				{
					if($i > $this->_pos)
					{
						//otherブロックを追加して文字列開始シークエンス開始
						$i = $this->add_other_block($i, __LINE__ );
					}
					
					$value = substr($this->_src, $this->_pos, strlen($open));
				}
				
				$i = $this->_pos;

				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_STRING_OPEN,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						$this->_env->BLOCK_VALUE => $value
					)
					, __LINE__
				);
				
				$i += strlen($open);
				$i = $this->parse_string_inner($i, $key, $open, $close, $esc, $open_reg, $close_reg);
				//文字列終了シークエンスかテキストの終わりを検出したら continue 2;
				return $i;
			}
		}
		
		return $i;
	}
	
	function parse_string_inner($index, $delim_num, $open, $close, $esc, $open_reg, $close_reg)
	{
		$i = $index;
		
		if((empty($esc)) && (!isset($open_reg)))
		{
			$close_reg = preg_quote($close, "/");
			$regexp = "/^([^{$close_reg}]*?){$close_reg}|\\0/s";
		}
		else if(!isset($open_reg))
		{
			$esc_reg = preg_quote($esc, "/");
			$close_reg = preg_quote($close, "/");
			$regexp = "/^(((?:{$esc_reg}{2})|(?:{$esc_reg}{$close_reg})|[^{$close_reg}])*){$close_reg}|\\0/s";
		}
		else
		{
			$regexp = "/{$close_reg}/s";
		}
		
		$check = substr($this->_src, $i);
		
		if(!isset($open_reg))
		{			
			if(preg_match($regexp, $check, $match))
			{
				$value = $match[1];
			}
			else
			{
				$value = substr($this->_src, $i);
			}
			
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_STRING,
					$this->_env->BLOCK_STYLE => $delim_num,
					$this->_env->BLOCK_CLASS => $delim_num,
					$this->_env->BLOCK_VALUE => $value
				)
				, __LINE__
			);
			
			$i += strlen($value);
			
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_STRING_CLOSE,
					$this->_env->BLOCK_STYLE => $delim_num,
					$this->_env->BLOCK_CLASS => $delim_num,
					$this->_env->BLOCK_VALUE => substr($this->_src, $i, strlen($close))
				)
				, __LINE__
			);			
			
			$i += strlen($close);
		}
		else
		{
			//$close_regに格納するパターンには二つまでのサブパターンを指定できることとする。
			//サブパターンの数が一つの場合、
			//一つ目のサブパターンの範囲へのマッチ文字列を終了シークエンスと見なす。
			//サブパターンの数が二つの場合、
			//一つ目のサブパターンの範囲は文字列本体に含め、
			//二つ目のサブパターンの範囲へのマッチ文字列は終了シークエンスと見なす。
			//一つ目のサブパターンは必ずパターン先頭から始まることとし、
			//二つ目のサブパターンは一つ目のサブパターンの直後に置く。
			//一つ目のサブパターンと二つ目のサブパターンは入れ子にはせず、
			//(ptn1)(ptn2)のように連続させること。
			//※なお、実際の検索時には前方にもう一つ、
			//文字列本体部分を表す別のサブパターンを連結するため、
			//マッチ結果のオフセットは定義クラスのものから一つずれる。
			if(preg_match($regexp, $check, $match, PREG_OFFSET_CAPTURE) && 
				$match[0][1] > 0)
			{
				if(count($match) > 1)
				{
					$value = substr($check, 0, $match[2][1]);
				}
				else
				{
					$value = substr($check, 0, $match[1][1]);
				}
			}
			else
			{
				$value = substr($this->_src, $i);
			}

			if(count($match) > 1) 
			{
				$end = $match[2][0];
			}
			else
			{
				$end = $match[1][0];
			}

			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_STRING,
					$this->_env->BLOCK_STYLE => $delim_num,
					$this->_env->BLOCK_CLASS => $delim_num,
					$this->_env->BLOCK_VALUE => $value
				)
				, __LINE__
			);
			
			$i += strlen($value);
			
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_STRING_CLOSE,
					$this->_env->BLOCK_STYLE => $delim_num,
					$this->_env->BLOCK_CLASS => $delim_num,
					$this->_env->BLOCK_VALUE => $end
				)
				, __LINE__
			);
			$i += strlen($end);
		}
		
		$this->_pos = $i;
		
		return $this->_pos;
	}
	
	function parse_single_comment_section($index)
	{
		$i = $index;
		//一行コメント開始シークエンスを取り出し
		foreach($this->COMMENT_SINGLE as $key => $open)
		{
			//一行コメント開始シークエンスを検出
			if (strpos($this->_src, $open, $i) === $i)
			{
				if($i > $this->_pos)
				{
					//otherブロックを追加して一行コメント開始
					$i = $this->add_other_block($i, __LINE__ );
				}
				
				//一行コメント部分をブロックに追加して
				//その直後の行末（改行の位置）へ移動後 continue 2;
				$pos = strpos($this->_src, "\n", $this->_pos);
				$pos = ($pos === false) ? $this->_count : $pos;
				
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_SINGLE_START,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, strlen($open))
					)
					, __LINE__
				);
				
				$this->_pos += strlen($open);
				
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_SINGLE_BODY,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						//改行の直前までを切り出し
						$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, ($pos - $this->_pos))
					)
					, __LINE__
				);
				
				$this->_pos = $pos;
				$i = $this->_pos;

				if($this->_pos >= $this->_count)
				{
					return $this->_pos;
				}
				
				return $i;
			}
		}
		
		return $i;
	}
	
	function parse_multi_comment_section($index)
	{
		$i = $index;
		//複数行コメント開始シークエンスと終了シークエンスの組み合わせを全部取り出す
		foreach($this->COMMENT_MULTI as $key => $delimiters)
		{
			//複数行コメント開始シークエンスと終了シークエンスを取り出し
			$open = $delimiters[$this->_env->COMMENT_MULTI_OPEN];
			$close = $delimiters[$this->_env->COMMENT_MULTI_CLOSE];
			$nesting = isset($delimiters[$this->_env->COMMENT_MULTI_NESTED]) ? $delimiters[$this->_env->COMMENT_MULTI_NESTED] : false;
			
			//複数行コメント開始シークエンスを検出
			if (strpos($this->_src, $open, $i) === $i)
			{
				if($i > $this->_pos)
				{
					//otherブロックを追加して複数行コメント開始
					$i = $this->add_other_block($i, __LINE__ );
				}
				
				//複数行コメント開始シークエンス部分をブロックに追加してその直後へ
				//スクリプト開始タグ部分をブロックに追加してタグの直後へ
				$this->add_block(array(
						$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_OPEN,
						$this->_env->BLOCK_STYLE => $key,
						$this->_env->BLOCK_CLASS => $key,
						$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, strlen($open))
					)
					, __LINE__
				);
				
				$i += strlen($open);
				$this->_pos = $i;
				//複数行コメント終了シークエンスかテキストの終わりを検出したら
				$i = $this->parse_multi_comment_inner($key, $open, $close, $nesting);
				return $i;
			}
		}
		
		return $i;
	}
	
	function parse_multi_comment_inner($delim_num, $open, $close, $nesting)
	{
		for($i = $this->_pos; $i < $this->_count ; $i++)
		{
			//コメントの入れ子に対応の場合
			if($nesting)
			{
				//コメントの終了を検出
				if (($pos = strpos($this->_src, $close, $i)) !== false)
				{
					$i = $pos;
					
					if($i == $this->_pos)
					{
						$value = "";
					}
					else
					{
						$value = substr($this->_src, $this->_pos, ($i - $this->_pos));
					}
					
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_BODY,
							$this->_env->BLOCK_STYLE => $delim_num,
							$this->_env->BLOCK_CLASS => $delim_num,
							$this->_env->BLOCK_VALUE => $value
						)
						, __LINE__
					);
					
					$i+= strlen($value);
					
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_CLOSE,
							$this->_env->BLOCK_STYLE => $delim_num,
							$this->_env->BLOCK_CLASS => $delim_num,
							$this->_env->BLOCK_VALUE => substr($this->_src, $i, strlen($close))
						)
						, __LINE__
					);

					$i += strlen($close);
					$this->_pos = $i;
					
					return $this->_pos;
				}
				
				//複数行コメント開始シークエンスを検出
				if (strpos($this->_src, $open, $i) === $i)
				{
					$i = $this->parse_multi_comment_nest_inner($key, $open, $close, $i + strlen($open));
				
					if($i >= $this->_count)
					{
						return $this->_pos;
					}
				}
			}
			//コメントの入れ子に非対応の場合
			else
			{
				//コメントの終了を検出
				if (($pos = strpos($this->_src, $close, $i)) !== false)
				{
					$i = $pos;
					
					if($i == $this->_pos)
					{
						$value = "";
					}
					else
					{
						$value = substr($this->_src, $this->_pos, ($i - $this->_pos));
					}
					
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_BODY,
							$this->_env->BLOCK_STYLE => $delim_num,
							$this->_env->BLOCK_CLASS => $delim_num,
							$this->_env->BLOCK_VALUE => $value
						)
						, __LINE__
					);
					
					$value = substr($this->_src, $i, strlen($close));
					
					$this->add_block(array(
							$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_CLOSE,
							$this->_env->BLOCK_STYLE => $delim_num,
							$this->_env->BLOCK_CLASS => $delim_num,
							$this->_env->BLOCK_VALUE => $value
						)
						, __LINE__
					);
					
					$i += strlen($value);
					$this->_pos = $i;
					
					return $this->_pos;
				}
			}
		}
		
		if($i == $this->_pos)
		{
			$value = "";
		}
		else
		{
			$value = substr($this->_src, $this->_pos, ($i - $this->_pos));
		}
		
		$this->add_block(array(
				$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_COMMENT_MULTI_BODY,
				$this->_env->BLOCK_STYLE => $delim_num,
				$this->_env->BLOCK_CLASS => $delim_num,
				$this->_env->BLOCK_VALUE => $value
			)
			, __LINE__
		);
		
		$this->add_block(array(
				$this->_env->BLOCK_TYPE => $this->_env->BLOCK_COMMENT_MULTI_CLOSE,
				$this->_env->BLOCK_STYLE => $delim_num,
				$this->_env->BLOCK_CLASS => $delim_num,
				$this->_env->BLOCK_VALUE => ""
			)
			, __LINE__
		);

		return $this->_pos;
	}
	
	function parse_multi_comment_nest_inner($delim_num, $open, $close, $index)
	{
		for($i = $index; $i < $this->_count ; /* void */)
		{
			//コメントの終了を検出
			if (strpos($this->_src, $close, $i) === $i)
			{
				return $i + strlen($close);
			}
			
			//複数行コメント開始シークエンスを検出
			if (strpos($this->_src, $open, $i) === $i)
			{
				$i = $this->parse_multi_comment_inner($key, $close_inner, $i + strlen($open));
			
				if($i >= $this->_count)
				{
					return $i;
				}
			}
			$i++;
		}
		
		return $i;
	}
	
	function add_block($values, $line)
	{
		$this->_blocks[] = $values;
		$this->_block_count++;
	}
	
	function add_other_block($index, $line)
	{
		if($index > $this->_pos)
		{
			//otherブロックを追加してスクリプト終了タグ開始
			$this->add_block(array(
					$this->_env->BLOCK_TYPE => $this->_env->BLOCK_TYPE_OTHER_BLOCK,
					$this->_env->BLOCK_STYLE => 0,
					$this->_env->BLOCK_CLASS => 0,
					$this->_env->BLOCK_VALUE => substr($this->_src, $this->_pos, $index - $this->_pos)
				)
				, $line
			);
		}

		$this->_pos = $index;
		
		return $index;
	}

	function append_log($text, $file, $line)
	{
		ThiEngine::append_log($text, $file, $line);
	}	
}
?>