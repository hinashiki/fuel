<?php
/**
 * extends sendmail driver
 *
 */
class Email_Driver_Sendmailwrapper extends Email\Email_Driver_Sendmail
{

	/**
	 * @overwrap
	 *
	 */
	public function send($validate = null)
	{
		// backup
		$body    = $this->get_body();
		$subject = $this->get_subject();
		$to      = $this->get_to();

		// EnvがProduction以外の場合はテストアドレスへ宛先を強制変更し、
		// タイトルをテストへ変更, 本文に本来のメール情報を記載する
		if(\Fuel::$env !== \Fuel::PRODUCTION)
		{
			$tos = array();
			foreach($to as $t){
				$tos[] = $t['email'];
			}
			$add_body = "original-to: ".implode(',', $tos)."\n"
			          . "------------------------------------------------\n";
			$this->clear_to()
				->to(\Config::get('email.debug.email'))
				->subject('['.\Fuel::$env.']'.mb_decode_mimeheader($subject))
				->body($add_body.$body);
		}


		// ISO-2022-JP対応
		$this->from(\Config::get('email.defaults.from.email'), \Config::get('email.defaults.from.name'))
			->body(mb_convert_encoding($this->get_body(), 'ISO-2022-JP'));

		$result = parent::send($validate);

		// オブジェクトのデータは検証や再利用が出来るように元に戻す
		$this->clear_to()
		     ->subject($subject)
		     ->body($body);
		foreach($to as $vals)
		{
			$this->to($vals['email'], $vals['name']);
		}
		return $result;
	}
}
