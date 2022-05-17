<?php
/*
Plugin Name: Survei kab.Kudus
Plugin URI: https://kaliwungu.kuduskab.go.id/
Description: Plugin Survei Kepuasan Masyarakat Kab.Kudus.
Version: 1.0.1
Author: Zanri Nova C
Author URI: https://www.usahawan-maju.blogspot.com/
*/

/*
Copyright 2022
*/

require_once 'survei_curl.php';

function kudus_plugintSurvei_isi(){
	$from_opd = explode(".",$_SERVER["SERVER_NAME"]);
	$survei_api_culr = new ServiceCurl();    
    $res = $survei_api_culr->service_curl_api($from_opd[0]);
	$data = json_decode($res,true);

	if (!empty($data)){
		foreach($data as $key => $value){
			$vals = json_decode($value,true);
			$menu_tab['menu'][]= array("tab_".$vals['id_survei'],$vals['nama_layanan']);
			$menu_tab['isi'][]= array("tab_".$vals['id_survei'],$vals['nama_layanan'],$vals['list_soal']);
		}
		echo '<h2>Survei Layanan Masyarakat</h2>
		<nav role="navigation" class="nav_survei"> <ul> 
		<li><a href="#">Pilih Survei <span class="sub-arrow"><i class="fas fa-caret-down"></i></span></a> <ul class="dropdown nav_survei_menu" > ';
		foreach($menu_tab['menu'] as $keytabs =>$valtabs){
			?>
             <li><a href="#" class="tablinks" onclick="openCity(event, '<?=$valtabs[0]?>')"><?=$valtabs[1]?></a></li>
			<?php
		}
		echo '</ul> 
		</li>
		<li><a href="/hasil-survei-kepuasan-masyarakat">Lihat Hasil</a></li>
		</ul> </nav>';
		foreach($menu_tab['isi'] as $keytabs =>$valtabs ){
			$id_surveily = explode('_',$valtabs[0]);
			echo '<div id="'.$valtabs[0].'" class="tabcontent_survei">
			<center><h3>'.$valtabs[1].'</center></h3>';
			?>
			<form class="floating-labels mt-4" method="post" action="https://dashboard.kuduskab.go.id/e_skm/saveSurvei">
				<input type='hidden' value='<?=date('ymd').time()?>' name='key_survei' />
				<input type='hidden' value='<?=$id_surveily[1]?>' name='id_survei' />
				<input type='hidden' value='<?=$_SERVER["SERVER_NAME"]?>' name='url' />
				<div id="data_responden<?=$valtabs[0]?>" style="margin-left:auto;margin-right:auto; width:320px;">
				    <h3>Data Responden</h3>
				    <div  class="row">
    			        <label for="">Nama Lenkap <span style="color:red;font-size: 20px;">*</span></label>
    			        <div class="col-md-12 input-text-wrap">
    				        <input type='text' id="name_responden" name="nama_responden" placeholder="contoh : Andika Pertama"  class="w-100" required/>
    				    </div>
				   </div>
				   <div  class="col-md-12">
    				    <label for="">Jenis Kelamin <span style="color:red;font-size: 20px;">*</span></label>
    				    <div class="col-md-12 input-text-wrap">
        				<select type='text' id="jenis_kelamin" name='jenis_kelamin' class="w-100" required>
        				    <option value="L">Laki - Laki</option>
        				    <option value="P">Perempuan</option>
        				</select>
        				</div>
    			    </div>
    			     <div  class="col-md-12">
    				    <label for="">Pendidikan <span style="color:red;font-size: 20px;">*</span></label>
    				    <div class="col-md-12">
        				<select type='text' id="pendidikan" name='pendidikan' class="w-100" required>
        				    <option value="s2">S2</option>
        				    <option value="s1">S1</option>
        				    <option value="slta">SLTA</option>
        				    <option value="smp">SMP</option>
        				    <option value="sd">SD</option>
        				</select>
        				</div>
    			    </div>
    			    <label><span style="color:red;font-size: 20px;">*</span>(Wajib diisi)</label>
    			    <div class="button button-primary" style="margin-top:20px" onclick="next('data_responden<?=$valtabs[0]?>','form_survei_isi<?=$valtabs[0]?>')"><center>Lanjut&nbsp;&nbsp;>></center></div>
				</div>
				<div id="form_survei_isi<?=$valtabs[0]?>">
				<?php
				$no = 1;
				foreach($valtabs[2] as $key2 => $val_soal){
					$opsi = json_decode($val_soal["opsi"]);
					
					echo '<div class="input-group" style="margin-top: 20px;">
					<h5>'.$no.". ".$val_soal["soal"].'</h5>
					</div>
					<div class="form-check"> 
					<input class="form-check-input" type="radio" name="soal_'.$val_soal["id_soal"].'" value="pilih_1" required>
					'.$opsi->pilih_1.'
					</div>
					<div class="form-check">
					<input class="form-check-input" type="radio" name="soal_'.$val_soal["id_soal"].'" value="pilih_2">
					'.$opsi->pilih_2.'
					</div>
					<div class="form-check">
					<input class="form-check-input" type="radio" name="soal_'.$val_soal["id_soal"].'" value="pilih_3">
					'.$opsi->pilih_3.'
					</div>
					<div class="form-check">
					<input class="form-check-input" type="radio" name="soal_'.$val_soal["id_soal"].'" value="pilih_4">
					'.$opsi->pilih_4.'
					</div>';
					
					$no++;
				}
				?>
				<div style="text-align:right">
				    <div class="button button-primary" style="margin-top:20px; width: 129px;float: left;" onclick="back('data_responden<?=$valtabs[0]?>','form_survei_isi<?=$valtabs[0]?>')"><center><< Kembali</center></div>
					<input type="submit"  name="kirim_survei" class="btn btn-success" style="margin-top:20px; "/>
			    	</div>
				</div>
			</form> 
			<script>
			     document.getElementById("form_survei_isi<?=$valtabs[0]?>").style.display = "none";
			</script>
			<?php
			echo '</div>';
		}

		?>
      <link  rel="stylesheet" href="https://dashboard.kuduskab.go.id/css/plugin_survei_wordpress.css" >
		<script>
		  //  document.getElementById("myDIV").style.display = "none";
		       function next(id,id2){
    		        document.getElementById(id).style.display = "none";
    		        document.getElementById(id2).style.display = "block";
    		    }
    		     function back(id,id2){
    		        document.getElementById(id).style.display = "block";
    		        document.getElementById(id2).style.display = "none";
    		    }
    		    
			function openCity(evt, cityName) {
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent_survei");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script> 
		<?php
	};
}
function kudus_plugintSurvei_hasil(){
	$from_opd = explode(".",$_SERVER["SERVER_NAME"]);
	$survei_api_culr = new ServiceCurl();    
    $res = $survei_api_culr->service_view_curl($from_opd[0]);
	$data = json_decode($res,true);

	if (!empty($data)){
	    ?>
	    
	    <link  rel="stylesheet" href="https://dashboard.kuduskab.go.id/assets/libs/apexcharts/dist/apexcharts.css" >
	    <link  rel="stylesheet" href="https://dashboard.kuduskab.go.id/css/style.css" >
		<script src="https://dashboard.kuduskab.go.id/js/custom/apexcharts.js"></script>
	    <?php
		foreach($data as $key => $value){
			$vals = json_decode($value['hasil'],true);
			$menu_tab['menu'][]= array("tab_".$value['id_survei'],$vals['nama_layanan']);
			$menu_tab['isi'][]= array("tab_".$value['id_survei'],$vals['nama_layanan'],$vals['data_soal']);
		}
		
		echo '
		<nav role="navigation" class="nav_survei"> <ul>
		<li><a href="#">Hasil Survei <span class="sub-arrow"><i class="fas fa-caret-down"></i></span></a> 
		<ul class="dropdown nav_survei_menu" > ';
		foreach($menu_tab['menu'] as $keytabs =>$valtabs){
			?>
             <li><a href="#" class="tablinks" onclick="openCity(event, '<?=$valtabs[0]?>')"><?=$valtabs[1]?></a></li>
			<?php
		}
		
		echo '</ul> 
		</li>
		<li><a href="/survey-kepuasan/">Pilih Survei</a></li>
		</ul> </nav>';
		foreach($menu_tab['isi'] as $keytabs =>$valtabs ){
			$id_surveily = explode('_',$valtabs[0]);
			echo '<div id="'.$valtabs[0].'" class="tabcontent_survei">
			<center><h3>'.$valtabs[1].'</center></h3>';
			unset($valtabs['2']['key_survei']);
			unset($valtabs['2']['pendidikan']);
			unset($valtabs['2']['id_survei']);
			unset($valtabs['2']['nama_responden']);
			unset($valtabs['2']['jenis_kelamin']);
			$total_responden = $valtabs['2']['kirim_survei']['Submit']['jumlah'];
			unset($valtabs['2']['kirim_survei']);
			echo "Jumlah Responden : ".$total_responden;
			$no = 1;
			foreach($valtabs['2'] as $keysoal => $value){
			   echo '
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="input-group" style="margin-top: 20px;">
                        <h5>'.$no.". ".$value["text"].'</h5>
                        </div>
                        <div class=""> 
                        '.$value["pilih_1"]['title'].' : '.$value["pilih_1"]['jumlah'].'
                        </div>
                        <div class="">
                        '.$value["pilih_2"]['title'].' : '.$value["pilih_2"]['jumlah'].'
                        </div>
                        <div class="">
                        '.$value["pilih_3"]['title'].' : '.$value["pilih_3"]['jumlah'].'
                        </div>
                        <div class="">
                        '.$value["pilih_4"]['title'].' : '.$value["pilih_4"]['jumlah'].'
                        </div> 
                    </div>
                    <div id="chart_point'.$no.$valtabs[0].'" class="col-md-6 col-sm-12"></div>
                
                </div>';
                ?>
                
                  <script>
                    var data_point = "<?=$value['pilih_1']['jumlah'].','.$value['pilih_2']['jumlah'].','.$value['pilih_3']['jumlah'].','.$value['pilih_4']['jumlah']?>",
                    data_title = "<?=$value['pilih_1']['title'].','.$value['pilih_2']['title'].','.$value['pilih_3']['title'].','.$value['pilih_4']['title']?>",
                    data_chart = data_point.split(","),
                    title_chart = data_title.split(",");

                   var options = {
                    series: [{
                      data: data_chart
                    }],
                    chart: {
                      type: 'bar',
                      height: 180,
                    },
                    
                      plotOptions: {
                      bar: {
                        barHeight: '85%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                          position: 'bottom'
                        },
                      }
                    },
                    colors: ['#d4526e', '#13d8aa', '#A5978B', '#2b908f'],
                    dataLabels: {
                      enabled: false
                    },
                    legend: {
                      show: true
                    },
                   tooltip: {
                    theme: 'dark',
                    x: {
                      show: true
                    },
                     y: {
                        title: {
                          formatter: function (val,opt) {
                            return ""
                          }
                        }
                      }
                    },
                    xaxis: {
                      categories: title_chart,
                    }
                  };

                  var chart = new ApexCharts(document.querySelector("#chart_point<?=$no.$valtabs[0]?>"), options);
                  chart.render();
                  </script>
                <?php
                $no++;
            
			}
			echo '</div>';
		}
		?>
		 <link  rel="stylesheet" href="https://dashboard.kuduskab.go.id/css/plugin_survei_wordpress.css" >
		 
		<script>
		  //  document.getElementById("myDIV").style.display = "none";
			function openCity(evt, cityName) {
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent_survei");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script> 
		<?php
	}
}
add_shortcode('survei_skm','kudus_plugintSurvei_isi');
add_shortcode('survei_skm_hasil','kudus_plugintSurvei_hasil');
