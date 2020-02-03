<?php

/* Potrebno je napraviti PHP funkciju koja prihvaća enkodiranu JSON matricu (array). Riješite zadatak prema uputama:

1) Sortirati prvi red dane 2D matrice u uzlaznom redoslijedu (ascending order). Prilikom sortiranja ostale redove je potrebno pomaknuti zajedno s prvim redom (pogledajte primjer na slici)
2) Pronaći najveći broj u sortiranoj 2D matrici, ne uzimajući u obzir prvi red. Potom izračunati sumu najvećih brojeva koordinata (koordinate počinju sa [1, 1]).
(HINT: Prvi red služi samo za sortiranje, ne koristi se u kalkulaciji)
(HINT: Ukoliko najveći broj postoji u više redova, sve koordinate najvećeg broja trebaju biti zbrojene)*/
	
	$givenJson = '{"1":{"1":4,"2":5,"3":8,"4":7,"5":6,"6":2},"2":{"1":5,"2":3,"3":7,"4":5,"5":2,"6":4},"3":{"1":3,"2":9,"3":1,"4":7,"5":7,"6":3},"4":{"1":6,"2":3,"3":7,"4":5,"5":7,"6":7},"5":{"1":1,"2":9,"3":6,"4":2,"5":9,"6":7},"6":{"1":1,"2":6,"3":9,"4":1,"5":1,"6":5}}';

	mainFunction($givenJson);

	function mainFunction(string $encodedArray): void
	{
		$decodedArray = json_decode($encodedArray, true);
	
		$sortedArray = sortArrayAscendingPerFirstRow($decodedArray);

		$sumOfCoordinatesWithBiggestNumber = sumBiggestNumberCoordinatesInArrayExceptFirstRow($sortedArray);

		echo "Sum of coordinate values with biggest number:" . $sumOfCoordinatesWithBiggestNumber;
	}

	function sortArrayAscendingPerFirstRow(array $unsortedArray): array
	{
		$amountOfRowsInArray = count($unsortedArray);
		do {
			$firstRowIsSorted = true;
			foreach ($unsortedArray as $key => $row) {
				if ($key > 1) {
					break;
				}
				foreach ($row as $key2 => $val) {
					if (multiKeyExists($key2+1, $unsortedArray)) {
						if ($val > $unsortedArray[$key][$key2+1]) {
							$tempVal = $unsortedArray[$key][$key2];
							$unsortedArray[$key][$key2] = $unsortedArray[$key][$key2+1];
							$unsortedArray[$key][$key2+1] = $tempVal;
							$firstRowIsSorted = false;

							for ($row2=2; $row2 <= $amountOfRowsInArray; $row2++) {
								$tempVal = $unsortedArray[$row2][$key2];
								$unsortedArray[$row2][$key2] = $unsortedArray[$row2][$key2+1];
								$unsortedArray[$row2][$key2+1] = $tempVal;
							}
						}
					}
	   			}
			}
		}while(!$firstRowIsSorted);

		return $unsortedArray;
	}

	function sumBiggestNumberCoordinatesInArrayExceptFirstRow($sortedArray): int
	{
		$biggestNumber = 0;
		$biggestNumberCoordinateSum = 0;

		foreach ($sortedArray as $key => $row) {

			foreach ($row as $col => $val) {

				if ($row === 2 && $col == 1) {
					$biggestNumber = $val;
				}
				
				if ($key > 1) {
					if ($val > $biggestNumber) {
						$biggestNumber = $val;
						$biggestNumberCoordinateSum = 0;
					}

					if ($val === $biggestNumber) {
						$biggestNumberCoordinateSum += ($key + $col);
					}
				}
			}
		}

		return $biggestNumberCoordinateSum;
	}

	function multiKeyExists($key, array $arr): bool
	{
	    if (array_key_exists($key, $arr)) {
	        return true;
	    }

	    foreach ($arr as $element) {
	        if (is_array($element)) {
	            if (multiKeyExists($key, $element)) {
	                return true;
	            }
	        }
	        
	    }

	    return false;
	}
?>