<?php
class STD3Des
{
	private $key = "";
	private $iv = "";

	/**
	* 构造，传递二个已经进行base64_encode的KEY与IV
	*
	* @param string $key
	* @param string $iv
	*/
	function __construct ($key, $iv)
	{
		if (empty($key) || empty($iv)) {
			echo 'key and iv is not valid';
			exit();
		}
		$this->key = $key;
		$this->iv = $iv;
	}

	/**
	*加密
	* @param <type> $value
	* @return <type>
	*/
	public function encrypt ($input)
	{
		$size = mcrypt_get_block_size('des', 'ecb');          
        $input = $this->pkcs5_pad($input, $size);          
        $key = $this->key;         
        $td = mcrypt_module_open('des', '', 'ecb', '');       
        $iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);      
        @mcrypt_generic_init($td, $key, $iv);         
        $data = mcrypt_generic($td, $input);          
        mcrypt_generic_deinit($td);      
        mcrypt_module_close($td);         
        $data = $data;         
        return $data;  
	}
	
	function pkcs5_pad ($text, $blocksize) {          
        $pad = $blocksize - (strlen($text) % $blocksize);         
        return $text . str_repeat(chr($pad), $pad);   
    }

	/**
	*解密
	* @param <type> $value
	* @return <type>
	*/
	public function decrypt ($value)
	{
		$td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
		$iv = base64_decode($this->iv);
		$key = base64_decode($this->key);
		mcrypt_generic_init($td, $key, $iv);
		$ret = trim(mdecrypt_generic($td, base64_decode($value)));
		$ret = $this->UnPaddingPKCS7($ret);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $ret;
	}

	private function PaddingPKCS7 ($data)
	{
		$block_size = mcrypt_get_block_size('tripledes', 'cbc');
		$padding_char = $block_size - (strlen($data) % $block_size);
		$data .= str_repeat(chr($padding_char), $padding_char);
		return $data;
	}

	private function UnPaddingPKCS7($text)
	{
		$pad = ord($text{strlen($text) - 1});
		if ($pad > strlen($text)) {
			return false;
		}
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
			return false;
		}
		return substr($text, 0, - 1 * $pad);
	}
}
?>