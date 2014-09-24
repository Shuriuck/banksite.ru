require_once 'PHPUnit/Framework.php';
<?php
	//ТЕСТИРУЕМАЯ ФУНКЦИЯ
	function rub_komis($rub) 
	{
		if($rub <= 0) return -1;
		else 
		{
			if($rub*0.01<=1000)
			{
				return $rub*=0.99;
			}
			else
			{
				return $rub-=1000;
			}
		}
	}
	//тест для функции взятия комиссии, покрывает всю таблицу с набором тестов для этой функции
	class comissTest extends PHPUnit_Framework_TestCase
	 {
	 	/**
	 	 * @dataProvider providerComm
	 	 */
		public function testComm($analytical, $summ)
		{
			$this->assertEquals($analytical, rub_komis($summ));
		}
		
		public function providerComm ()
		{
			return array (
					//1% меньше 1000, должна вернуть вернет (сумма - 1%)
					array(948.42,958),
					array(4246.11,4289),
 					array(453.6378, 458.22),
					array(10164.5478, 10267.22),
					//число меньше нуля
					array (-1,-2000),
 					//1% == 1000
 					array (99000,100000),
					//1% > 1000, должна сняться 1000
 					array (999000,1000000),
					array (4581649.5, 4582649.5),
					//при нулевом балансе
					array (-1, 0)
			);
		}
		
	}
?>