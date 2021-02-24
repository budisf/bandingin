<?php

	//no 1

	function prima($n){
  
              $counter = 0; 
              for($j=1;$j<=$n;$j++){ 
                  
                    if($n % $j==0){ 
                        
                          $counter++;
                    }
              }
            
            if($counter==2){
                 
                   print $n." adalah bilangan prima <br/>";
            } else{

            	   print $n." bukan bilangan prima <br/>";
            }
	
	} 

	prima(20);

	//no 2

	function maksimal(){
	error_reporting(0);
 	$bilangan = array(11,6, 31, 201, 99, 861, 1, 7, 14, 79);
	$jumlah = count($bilangan);
	for($i=0;$i<=$jumlah-1;$i++){
		for($j=0;$j<=($jumlah-($i+1));$j++){
			if($bilangan[$j] > $bilangan[$j+1]){
				$k = $bilangan[$j];
				$bilangan[$j] = $bilangan[$j-1];
				$bilangan[$j+1] = $k;
			}
		}
	}
	echo "data terbesar adalah ".$k."<br>";
	}	
 	maksimal();

	//no 3
	$star=1;
	for($a=$star;$a<9;$a++){
	for($b=$star;$b<=$a;$b++){
		echo $b;
	}
	echo "<br>";
	}

	// no 4
	function urutan(){
	$array  =  array(99, 2, 64, 8, 111, 33, 65, 11, 102, 50); // data yang akan diurutkan dari terkecil ke terbesar
	$jumlah = count($array);
	for($i=0;$i<=$jumlah-1;$i++){
		for($j=0;$j<=($jumlah-($i+1));$j++){
			if($array[$j] > $array[$j+1]){
				$k = $array[$j];
				$array[$j] = $array[$j+1];
				$array[$j+1] = $k;
			}
		}
			print $k.",";
	}
	echo "<br>";

	}
	urutan();

	// no 5 

	for ($i=1; $i < 5 ; $i++) { 
		for ($j=$i; $j < 13; $j++) { 
			echo $j." ";
			$j = $j + 3;
		}
		echo "<br>";
	}

?>