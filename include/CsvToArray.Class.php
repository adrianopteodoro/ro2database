 <?php
 /**
 * Zend Framework
 *
 * LICENSE
 *
 * Arquivo de livre reprodução
 * 
 * Utilização:
 * 
 * echo '<pre>';
 * print_r(CsvToArray('teste.csv'));
 * echo '</pre>';
 *
 * 
 * 
 * @category   CSV
 * @package    ScvToArray
 * @copyright  Copyleft (c) 2009-2010 . (http://www.pontophp.com.br)
 * @version    1.0
 */
 final class CsvToArray{

 	/**
 	 * Função estática principal. O parâmetro $delimiter não é obrigatório, apenas se for utilizado outro tipo de caractere, por exemplo a vírgula (,).
 	 *
 	 * @param string $file
 	 * @param char $delimiter
 	 * @return array
 	 */
 	public static function open($file, $delimiter = ';'){
 		return self::ordenaMultiArray(self::csvArray($file, $delimiter), 0);
 	}

 	private function csvArray($file, $delimiter)
 	{
 		$result = Array();
 		$size = filesize($file) + 1;
 		$file = fopen($file, 'r');
 		$keys = fgetcsv($file, $size, $delimiter);
 		while ($row = fgetcsv($file, $size, $delimiter))
 		{
 			for($i = 0; $i < count($row); $i++)
 			{
 				if(array_key_exists($i, $keys))
 				{
 					$row[$keys[$i]] = $row[$i];
 				}
 			}
 			$result[] = $row;
 		}

 		fclose($file);

 		return $result;
 	}
 	private function ordenaMultiArray($multiArray, $secondIndex)
 	{
 		while (list($firstIndex, ) = each($multiArray))
 		$indexMap[$firstIndex] = $multiArray[$firstIndex][$secondIndex];
 		asort($indexMap);
 		while (list($firstIndex, ) = each($indexMap))
 		if (is_numeric($firstIndex))
 		$sortedArray[] = $multiArray[$firstIndex];
 		else $sortedArray[$firstIndex] = $multiArray[$firstIndex];
 		return $sortedArray;
 	}
 }
?>