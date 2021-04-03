<?php
	function descuentaFinDeSemana($horaActivacion){
			$Finday=0;
			$FindHour=0;
			$FindHour2=0;
			/* $Descuento=0;	 */
			if(date("l")=="Monday"||date("l")=="Tuesday"||date("l")=="Wednesday"||date("l")=="Thursday"){
				$Finday=1;

				if($horaActivacion>='23:00:00'&&$horaActivacion<='23:59:59'){
					$FindHour=1;
					/* echo "entro if 1"."<br>"; */
				}
				if($horaActivacion>='00:00:01'&&$horaActivacion<='06:00:00'){
					$FindHour2=1;
					/* echo "entro if 2"; */
				}
			}
			if($Finday==1&&($FindHour==1||$FindHour2==1)){
				$Descuento=1;
				/* echo "entro if 3"."<br>"; */
			}else{
				$Descuento=0;
			}

			/* echo $Descuento; */


		return $Descuento;	
	}

/* descuentaFinDeSemana("23:00:00"); */


?>