<?php
require_once('function.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="audio">
     <?php
		$list=audio_list();
		if(!empty($list))
		{
			foreach($list as $a)
			{
				echo '<audio id="audio'.$a['ID'].'" class="audioitem" src="'.$a['path'].'"></audio>';
			}
		}
	 ?>
     </div>
    <div class="alert alert-warning">Allow Autoplay Audio di browser. Keterangan kode ada pada source code</div>
    <div class="container">
    
    	<div class="col-md-6 col-md-offset-3">
    		<div class="form-group">
    			<label>Pilih Audio</label>
    			<select id="audiolist" class="form-control">
    				<?php
    				if(!empty($list))
					{
						foreach($list as $a2)
						{
							echo '<option value="audio'.$a2['ID'].'">'.$a2['file'].'</option>';
						}
					}
    				?>
    			</select>
    		</div>
    		<div class="form-group">
    			<button type="button" id="panggil3" class="btn btn-primary btn-lg">Dengarkan</button>
    		</div>
    	</div>
    	
    	<div class="col-md-6 col-md-offset-3">
    		<div class="form-group">
    			<label>Pilih Alfabet</label>
    			<select id="alfabet" class="form-control">
    				<?php
    				$alfa = range('A', 'Z');
    				foreach($alfa as $a)
    				{
						echo '<option value="'.strtolower($a).'">'.$a.'</option>';
					}
    				?>
    			</select>
    		</div>
    		<div class="form-group">
    			<button type="button" id="panggil2" class="btn btn-primary btn-lg">Dengarkan</button>
    		</div>
    	</div>
    
    	<div class="col-md-6 col-md-offset-3">
    		<div class="form-group">
    			<label>Entri Nomor</label>
    			<input type="number" id="nomor" class="form-control input-lg" placeholder="1 sampai 999" max="999" value="234"/>
    		</div>
    		<div class="form-group">
    			<button type="button" id="panggil" class="btn btn-primary btn-lg">Dengarkan</button>
    		</div>
    	</div>
    	    	
    </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    
    <script>
    var totalwaktu = 0; //variable delay untuk memainkan audio banyak
	$(document).ready(function(){
			
		$("#panggil").on('click',function(){
			var nomor=$("#nomor").val();
			
			if(nomor < 1000)
			{
				setTimeout(function(){
					panggil_nomor(nomor);
					totalwaktu=0;
				},1000);
			}else{
				$("#nomor").val('');
				alert('Range 1 - 999');
			}
			
		});
		
		$("#panggil2").on('click',function(){
			var alfabet=$("#alfabet").val();
			
			setTimeout(function(){
				play('audio'+alfabet+'');
				totalwaktu=0;
			},1000);
			
		});
		
		$("#panggil3").on('click',function(){
			var audiolist=$("#audiolist").val();
			
			setTimeout(function(){
				play(audiolist);
				totalwaktu=0;
			},1000);
			
		});
	
	});
	
	//PLAY FRAMEWORK
	function play(id)
	{
		const playPromise=document.getElementById(id).play();
		if(playPromise !== null) // Jika tidak diblock browser, jalankan
		{
			playPromise.catch(() => {
				document.getElementById(id).pause();
				document.getElementById(id).currentTime=0;
				document.getElementById(id).play();
			})
		}
	}
	
	
	function panggil_nomor(nomor)
	{
		totalwaktu=0;
		if(nomor < 1000) // File audio nya cuma bisa sampe 999 :D
		{
					
			if(nomor > 20) // Di audio file ada audio dari 1-20, jadi kita filter mulai dari 21
			{
				var satuan='';
				if(nomor.toString().length == 3) // Jika jumlah karakter 3 100-999
				{
					satuan='ratus'; //bikin satuan ratus
				}
				
				if(nomor > 20 && nomor < 100) // Bikin pemanggil puluhan
				{
					var b1=nomor.toString().substring(0,1); // Ambil karakter pertama misal 2
					var puluh=b1+'0'; //jadikan ke puluhan 10-90
					setTimeout(function(){ //setTimeout dibikin untuk stop periode audionya. 
						play('audio'+puluh+''); //play yg puluhan misal *dua puluh*
					},totalwaktu);
					totalwaktu=totalwaktu+1000; //Selalu tambahkan delay-nya
					
					var b2=nomor.toString().substring(1,2); //Ambil karakter 2
					if(b2 !='0') // Filter 0 terlebih dahulu, karena ada audio 10-90
					{
						setTimeout(function(){
							play('audio'+b2+''); //Mainkan karakter ke dua, Milal 3 "tiga"
						},totalwaktu);
						totalwaktu=totalwaktu+1000; //tambah delay
					}
					
				}
				
				if(satuan == 'ratus') // bikin pemanggil ratusan
				{
					var b1=nomor.toString().substring(0,1); //Ambil karakter pertama. Misal 2
					var ratus=b1+'00'; //jadikan ke ratusan 100-900. Misal 200 
					setTimeout(function(){
						play('audio'+ratus+''); //mainkan yg ratusan misal *dua ratus*
					},totalwaktu);				
					totalwaktu=totalwaktu+1200; //tambah delay
					
					
					//Panggil puluhan
					var b2=nomor.toString().substring(1,2); //Ambil karakter ke 2. Utk menentukan apakah 0 atau tidak. Contoh 234 karakter ke 2 nya adalah 3. Klo 204, maka karakter ke 2 nya adalah 0
					var b23=nomor.toString().substring(1,3); //Ambil karakter ke 2 dan 3. Menentukan apakah ini puluhan atau tidak. 234 jadi 34					
					var b3=nomor.toString().substring(2,3); //Ambil karakter ke 3. Klo b2 nilai 0 maka. Referensi b2
					
					if(b23 > 0) //jika karakter ke 2 dan 3 lebih dari 0
					{
						if(b23 > 20 && b23 < 100) // Filter yg ga ada audio 21-99
						{
							var bx1=b23.toString().substring(0,1); //Cari karakter 1 dari pecahan karakter ke 2 dan 3
							var puluh=bx1+'0'; //jadikan variable puluhan 10,20,30,dst
							setTimeout(function(){
								play('audio'+puluh+''); //mainkan puluh
							},totalwaktu);
							totalwaktu=totalwaktu+1000; //delay
							
							var bx23=b23.toString().substring(1,2); //Cari karakter 2 dari pecahan karakter ke 2 dan 3
							if(bx23 !='0') //Filter jika tidak 0. Karena klo 0, maka jalankan yg puluhan aja
							{
								setTimeout(function(){
									play('audio'+bx23+''); //Mainkan karakter ke 3
								},totalwaktu);
								totalwaktu=totalwaktu+1000; //Delay
							}
						}else{
							setTimeout(function(){ 
								play('audio'+b3+''); //Kalau 204, maka mainkan 4 *empat* aja
							},totalwaktu);
							totalwaktu=0; //reset lg delay jd 0
						}
					}
					
				}
				
			}else{
				setTimeout(function(){
					play('audio'+nomor+''); //Mainkan 1 sampai 20
				},totalwaktu);
				totalwaktu=0; //reset lg delay jd 0
			}
		}else{
			alert('Range 1 - 999');
		}
	}
	
	
	function panggil_urut(counter,nomor)
	{
		panggil_nomor(nomor);
		totalwaktu = 8568.163;
	}
	
	
	</script>
    
  </body>
</html>