<?php
	/**
	 * Libreria para o template Default
	 */
	class Libhelper
	{
		/**
		 * [MenuHeader Para el menu principal de PSI]
		 * @param [type] $seccion [Seccion do site]
		 */
	   	public static function MenuHeader(){
	    	/*$areas_id = Session::get('_SETORID');
			$menuHeader = Load::model('contenidomenu');
			$idiomas_id =Session::get('_IDIDIOMA');*/
			$areas_id = 1;
			$idiomas_id = 1;
			$menuHeader = Load::model('contenidomenu');
			foreach ($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id is NULL and posicion='MenuPrincipal' and activo='1'","order: orden asc") as $key => $menu) {
				$c1=$menuHeader->count("conditions: areas_id=$areas_id and idiomas_id=1 and contenidomenu_id=$menu->id and activo='1'");
				if ($c1==0) {
					if($menu->redireccionar==1)	{	?>
				   		<li class="nav-link <?php echo ($key==0) ? '' : '' ?>"><a class="nav-link text-dark text-uppercase font-weight-bold" target="<?php echo $menu->destino ?>" href="<?php echo $menu->redireccionarurl ?>" ><?php echo $menu->nombre ?><span class="sr-only"></span></a></li>
					<?
					}else{ ?>
						<li class="nav-link  <?php echo ($key==0) ? '' : '' ?>"><a class="nav-link text-dark text-uppercase font-weight-bold" target="<?php echo $menu->destino ?>" href="<?php echo $menu->urlpath ?>" ><?php echo $menu->nombre ?><span class="sr-only"></span></a></li>
					<?
					}
				}else{ ?>
					<li class="nav-link dropdown">
						<a class="nav-link text-dark text-uppercase font-weight-bold" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu->nombre ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
						 	foreach($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id=$menu->id and activo='1'","order: orden asc") as $submenu){
					            $c2=$menuHeader->count("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id=$submenu->id and activo='1'");
					            if ($c2==0) {
					            	if($submenu->redireccionar==1){ ?>
										<li class="dropdown-item"><a target="<?php echo $submenu->destino ?>" href="<?= $submenu->redireccionarurl ?>" title="Ir a <?= $submenu->titulo ?>"><?php echo $submenu->nombre ?></a></li>
									<?
									}else{ ?>
										<li class="dropdown-item"><a target="<?php echo $submenu->destino ?>" href="/<?=$menu->urlpath ?>/<?=$submenu->urlpath ?>" title="Ir a <?= $submenu->titulo ?>"><?php echo $submenu->nombre ?></a></li>
									<?
									}
					            }else { ?>
					            	<li class="dropdown-submenu">
					            		<a tabindex="0" class="dropdown-toggle"  data-toggle="dropdown" href="#"><?php echo $submenu->nombre ?></a>
					            		<ul class="dropdown-menu" role="menu">
					            			<?php
						            		foreach($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=1 and contenidomenu_id=$submenu->id and activo='1'","order: orden asc") as $treemenu){
						            			if($treemenu->redireccionar==1){ ?>
													<li><a tabindex="-1" target="<?php echo $treemenu->destino ?>" href="<?= $treemenu->redireccionarurl ?>" title="Ir a <?= $treemenu->titulo ?>"><?php echo $treemenu->nome ?></a></li>
														<?
												}else{ ?>
													<li><a tabindex="-1" target="<?php echo $treemenu->destino ?>" href="/<?=$menu->urlpath ?>/<?=$submenu->urlpath ?>/<?=$treemenu->urlpath ?>" title="Ir a <?= $treemenu->titulo ?>"><?php echo $treemenu->nome ?></a></li>
												<?
												}
						            		}
						            		?>
					            		</ul>
					            	</li>
					            <?php
					            }
					        }
				        	?>
						 </ul>
					</li>
				<?php
				}
			}
		}
		public static function MenuHeaderConteudo(){
			$areas_id = 1;
			$idiomas_id = 1;
			$menuHeader = Load::model('contenidomenu');
			foreach ($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id is NULL and posicion='MenuPrincipal' and activo='1'","order: orden asc") as $key => $menu) {
				$c1=$menuHeader->count("conditions: areas_id=$areas_id and idiomas_id=1 and contenidomenu_id=$menu->id and activo='1'");
				if ($c1==0) {
					if($menu->redireccionar==1)	{	?>
				   		<li class="<?php echo ($key==0) ? '' : '' ?>"><a target="<?php echo $menu->destino ?>" href="/<?php echo $menu->redireccionarurl ?>" ><?php echo $menu->nombre ?><span class="sr-only"></span></a></li>
					<?
					}else{ ?>
						<li class="<?php echo ($key==0) ? '' : '' ?>"><a target="<?php echo $menu->destino ?>" href="/<?php echo $menu->urlpath ?>" ><?php echo $menu->nombre ?><span class="sr-only"></span></a></li>
					<?
					}
				}else{ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu->nombre ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
						 	foreach($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id=$menu->id and activo='1'","order: orden asc") as $submenu){
					            $c2=$menuHeader->count("conditions: areas_id=$areas_id and idiomas_id=$idiomas_id and contenidomenu_id=$submenu->id and activo='1'");
					            if ($c2==0) {
					            	if($submenu->redireccionar==1){ ?>
										<li><a target="<?php echo $submenu->destino ?>" href="<?= $submenu->redireccionarurl ?>" title="Ir a <?= $submenu->titulo ?>"><?php echo $submenu->nombre ?></a></li>
									<?
									}else{ ?>
										<li><a target="<?php echo $submenu->destino ?>" href="/<?=$menu->urlpath ?>/<?=$submenu->urlpath ?>" title="Ir a <?= $submenu->titulo ?>"><?php echo $submenu->nombre ?></a></li>
									<?
									}
					            }else { ?>
					            	<li class="dropdown-submenu">
					            		<a tabindex="0" class="dropdown-toggle"  data-toggle="dropdown" href="#"><?php echo $submenu->nombre ?></a>
					            		<ul class="dropdown-menu" role="menu">
					            			<?php
						            		foreach($menuHeader->find("conditions: areas_id=$areas_id and idiomas_id=1 and contenidomenu_id=$submenu->id and activo='1'","order: orden asc") as $treemenu){
						            			if($treemenu->redireccionar==1){ ?>
													<li><a tabindex="-1" target="<?php echo $treemenu->destino ?>" href="<?= $treemenu->redireccionarurl ?>" title="Ir a <?= $treemenu->titulo ?>"><?php echo $treemenu->nome ?></a></li>
														<?
												}else{ ?>
													<li><a tabindex="-1" target="<?php echo $treemenu->destino ?>" href="/<?=$menu->urlpath ?>/<?=$submenu->urlpath ?>/<?=$treemenu->urlpath ?>" title="Ir a <?= $treemenu->titulo ?>"><?php echo $treemenu->nome ?></a></li>
												<?
												}
						            		}
						            		?>
					            		</ul>
					            	</li>
					            <?php
					            }
					        }
				        	?>
						 </ul>
					</li>
				<?php
				}
			}
		}
		public static function destaque(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $Destaque = Load::model('noticiasyeventos')->destaques($areas_id, $idiomas_id); ?>
	        <?php
	        foreach ($Destaque as $key => $value) {
	            if ($value->redireccionar == 1) { ?>
		            <div class="carousel-item  <?php echo ($key == 0) ? 'active' : '' ?>">
		            	<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title="<?php echo $value->titulo ?>"><img class="img-fluid" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		            	<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title="<?php echo $value->titulo ?>"><div class="carousel-caption hidden-xs">
		            		<p><?php echo $value->resumen ?></p>
		            	</div></a>
		            </div>
	            <?
	            }else{ ?>
					<div class="carousel-item  <?php echo ($key == 0) ? 'active' : '' ?>">
		            	<a href="<?php echo '/destaque/'.$value->urlpath ?>" title=""><img class="img-fluid" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		            	<a href="<?php echo '/destaque/'.$value->urlpath ?>" title=""><div class="carousel-caption hidden-xs">
		            		<p><?php echo $value->resumen ?></p>
		            	</div></a>
		            </div>
	            <?
	            }
	        } ?>
	    <?php
		}
		public static function projetos(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $projetos = Load::model('noticiasyeventos')->projetos($areas_id, $idiomas_id);
		    foreach ($projetos as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pb-3">
		            	<div class="card">
			            	<a class="img-card" target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>>
		                        <img class="card-img-top img-fluid" src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>">
		                    </a>

		                    <div class="card-content">
	                            <h4 class="card-title">
	                                <a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><?php echo $value->subtitulo ?></a>
	                            </h4>
	                            <p class="">
	                                Tutorial to make a carousel bootstrap by adding more wonderful effect fadein ...
	                            </p>
	                        </div>

	                        <div class="card-read-more">
	                            <a href="http://www.fostrap.com/2016/03/bootstrap-3-carousel-fade-effect.html" class="btn btn-link btn-block">
	                                Lêr mais
	                            </a>
	                        </div>
						</div>
					</div>
		        <?
		        }else{ ?>
		            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pb-3">
		            	<div class="card">
		            		<a class="img-card" target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>">
		                        <img class="card-img-top img-fluid" src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>">
		                    </a>

		                    <div class="card-content">
	                            <h4 class="card-title">
	                                <a target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>"><?php echo $value->subtitulo ?></a>
	                            </h4>
	                            <p class="">
	                                Tutorial to make a carousel bootstrap by adding more wonderful effect fadein ...
	                            </p>
	                        </div>

	                        <div class="card-read-more">
	                            <a href="http://www.fostrap.com/2016/03/bootstrap-3-carousel-fade-effect.html" class="btn btn-link btn-block">
	                                Lêr mais
	                            </a>
	                        </div>
		            	</div>
					</div>
		        <?
		        }
		    }
		}

		public static function palestras(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $projetos = Load::model('noticiasyeventos')->projetos($areas_id, $idiomas_id);
		    foreach ($projetos as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pb-3">
						<div class="card">
		            		<div class="image">
		            			<img class="card-img-top img-fluid" src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>">
		            		</div>
		            		<div class="details">
		            			<div class="center">
		            				<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><h1><?php echo $value->subtitulo ?></h1></a>
		            				<p><?php echo $value->resumen; ?></p>
		            				<a class="btn btn-outline-dark btn-sm" target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><i class="fa fa-plus"> </i> INFO</a>
		            			</div>
		            		</div>
		            	</div>
					</div>
		        <?
		        }else{ ?>
		            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pb-3">
		            	<div class="card">
		            		<div class="image">
		            			<img class="card-img-top img-fluid" src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>">
		            		</div>
		            		<div class="details">
		            			<div class="center">
		            				<a target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>"><h1><?php echo $value->subtitulo ?></h1></a>
		            				<p><?php echo $value->resumen; ?></p>
		            				<a class="btn btn-outline-dark btn-sm" target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>"><i class="fa fa-plus"> </i> INFO</a>
		            			</div>
		            		</div>
		            	</div>
					</div>
		        <?
		        }
		    }
		}
		
		public static function projetosConsultorio(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $projetos = Load::model('noticiasyeventos')->projetos($areas_id, $idiomas_id);
		    foreach ($projetos as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <div class="col-md-12">
						<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><img src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>"></a>
						<h5><a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><?php echo $value->subtitulo ?></a></h5>
					</div>
		        <?
		        }else{ ?>
		            <div class="col-md-12">
						<a target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>"><img src="<?php echo $value->miniatura	?>" alt="<?php echo $value->titulo ?>"></a>
						<h5><a target="<?php echo $value->linkblank ?>" href="<?php echo 'projetos/'.$value->urlpath ?>"><?php echo $value->subtitulo ?></a></h5>
					</div>
		        <?
		        }
		    }
		}
		public static function projetosConteudo(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $projetos = Load::model('noticiasyeventos')->projetos($areas_id, $idiomas_id);
		    foreach ($projetos as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		        	<li role="<?php echo $value->titulo ?>" class="" style="background: #F5F5F5;border-radius: 5px;"><a class="hvr-underline-from-left" target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><?php echo $value->titulo ?></a>
		        	</li>
		        <?
		        }else{ ?>
		        	<li role="<?php echo $value->titulo ?>" class="" style="background: #F5F5F5;border-radius: 5px;"><a class="hvr-underline-from-left" target="<?php echo $value->linkblank ?>" href="<?php echo '/projetos/'.$value->urlpath ?>"><?php echo $value->subtitulo ?></a>
		        	</li>
		        <?
		        }
		    }
		}
		public static function dicasDeSaude(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $dicasDeSaude = Load::model('noticiasyeventos')->dicasDeSaude($areas_id, $idiomas_id); ?>
	        <div id="myCarousel" class="carousel slide">
	        	<div class="carousel-inner">
			        <?php
				    foreach ($dicasDeSaude as $key => $value) {
				        if ($value->redireccionar == 1) { ?>
				        	<div class="item <?php echo ($key==0) ? 'active' : '' ?>">
		                    	<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><img class="thumbnail" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		                    	<div class="caption">
		                    		<h4 style="text-align: center"><a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title="" class="btn btn-sm btn-success"><?php echo $value->subtitulo ?></a></h4>
		                    	</div>
		                    </div>
				        <?
				        }else{ ?>
				            <div class="item <?php echo ($key==0) ? 'active' : '' ?>">
		                    	<a href="<?php echo 'dicasdasaude/'.$value->urlpath ?>"><img class="thumbnail" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		                    	<div class="caption">
		                    		<h4 style="text-align: center"><a href="<?php echo 'dicasdasaude/'.$value->urlpath ?>" title="" class="btn btn-sm btn-success"><?php echo $value->subtitulo ?></a></h4>
		                    	</div>
		                    </div>
				        <?
				        }
				    } ?>
				</div>
				<ol class="carousel-indicators">
		        	<?php
		        		foreach ($dicasDeSaude as $key => $value) {
		            		if ($value->redireccionar == 1) { ?>
		            			<li data-target="#myCarousel" data-slide-to="<?php echo $key ?>" class="<?php echo ($key==0) ? 'active' : '' ?>"></li>
		            		<?php
		            		}else{ ?>
								<li data-target="#myCarousel" data-slide-to="<?php echo $key ?>" class="<?php echo ($key==0) ? 'active' : '' ?>"></li>
		            		<?php
		            		}
		            	}
		        	?>
		        </ol>
			</div>
		<?php
		}
		public static function dicasConteudo(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $dicasDeSaude = Load::model('noticiasyeventos')->dicasDeSaude($areas_id, $idiomas_id);
	        foreach ($dicasDeSaude as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		        	<li role="<?php echo $value->titulo ?>" class="" style="background: #F5F5F5;border-radius: 5px;"><a class="hvr-underline-from-left" target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><?php echo $value->titulo ?></a>
		        	</li>
		        <?
		        }else{ ?>
		        	<li role="<?php echo $value->titulo ?>" class="" style="background: #F5F5F5;border-radius: 5px;"><a class="hvr-underline-from-left" target="<?php echo $value->linkblank ?>" href="<?php echo '/dicasdasaude/'.$value->urlpath ?>"><?php echo $value->subtitulo ?></a>
		        	</li>
		        <?
		        }
		    }
		}
		public static function analiseDaSaude(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $analiseDaSaude = Load::model('noticiasyeventos')->analiseDaSaude($areas_id, $idiomas_id);
		    foreach ($analiseDaSaude as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title="<?php echo $value->titulo ?>"><img src="<?php echo $value->miniatura ?>" alt="" width="100%"></a>
		        <?
		        }else{ ?>
		           <a target="<?php echo $value->linkblank ?>" href="<?php echo 'analisedasaude/'.$value->urlpath ?>" title="<?php echo $value->titulo ?>"><img src="<?php echo $value->miniatura ?>" alt="" width="100%"></a>
		        <?
		        }
		    }
		}
		public static function lojaVirtual(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $loja = Load::model('noticiasyeventos')->lojaVirtual($areas_id, $idiomas_id); ?>
	        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
	        	<div class="carousel-inner">
			        <?php
				    foreach ($loja as $key => $value) {
				        if ($value->redireccionar == 1) { ?>
				        	<div class="item <?php echo ($key==0) ? 'active' : '' ?>">
		                    	<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>"><img class="thumbnail" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		                    	<!--<div id="carousel-caption">
								  	<a target="<?php //echo $value->linkblank ?>" href="<?php //echo $value->linkurl ?>" title="Libro" class="btn btn-primary">Clique Aqui >></a><br><br>
								  	<a target="<?php //echo $value->linkblank ?>" href="<?php //echo $value->linkurl ?>" title="Libro" class="btn btn-success">Compre Agora</a>
						    		<hr>
					            </div>-->
		                    </div>
				        <?
				        }else{ ?>
				            <div class="item <?php echo ($key==0) ? 'active' : '' ?>">
		                    	<a href="<?php echo 'loja/'.$value->urlpath ?>"><img class="thumbnail" src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"></a>
		                    	<!--<div id="carousel-caption">
								  	<a target="<?php //echo $value->linkblank ?>" href="<?php //echo 'loja/'.$value->urlpath ?>" title="Libro" class="btn btn-primary">Clique Aqui >></a><br><br>
								  	<a target="<?php //echo $value->linkblank ?>" href="<?php //echo 'loja/'.$value->urlpath ?>" title="Libro" class="btn btn-success">Compre Agora</a>
						    		<hr>
					            </div>-->
		                    </div>
				        <?
				        }
				    } ?>
				</div>
				<ol class="carousel-indicators">
		        	<?php
		        		foreach ($loja as $key => $value) {
		            		if ($value->redireccionar == 1) { ?>
		            			<li data-target="#myCarousel2" data-slide-to="<?php echo $key ?>" class="<?php echo ($key==0) ? 'active' : '' ?>"></li>
		            		<?php
		            		}else{ ?>
								<li data-target="#myCarousel2" data-slide-to="<?php echo $key ?>" class="<?php echo ($key==0) ? 'active' : '' ?>"></li>
		            		<?php
		            		}
		            	}
		        	?>
		        </ol>
			</div>
		<?php
		}
		public static function clinica(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $clinica = Load::model('noticiasyeventos')->clinica($areas_id, $idiomas_id);
		    foreach ($clinica as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <div class="portfolio-item print">
		                <div class="portfolio">
		                    <a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" data-lightbox-gallery="portfolio">
		                        <img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"/>
		                        <div class="portfolio-overlay hvr-rectangle-out">
		                            <h2 class="margin-bottom-small">
		                                <strong class="white-color bold-text"><?php echo $value->titulo ?></strong>
		                            </h2>
		                            <div class="button">VER ESPECIALIDADE</div>
		                        </div>
		                    </a>
		               	</div>
		            </div>
		        <?
		        }else{ ?>
		           <div class="portfolio-item print">
		                <div class="portfolio">
		                    <a target="<?php echo $value->linkblank ?>" href="/clinica/<?php echo $value->urlpath ?>" data-lightbox-gallery="portfolio">
		                        <img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"/>
		                        <div class="portfolio-overlay hvr-rectangle-out">
		                            <h2 class="margin-bottom-small">
		                                <strong class="white-color bold-text"><?php echo $value->titulo ?></strong>
		                            </h2>
		                            <div class="button">VER ESPECIALIDADE</div>
		                        </div>
		                    </a>
		               	</div>
		            </div>
		        <?
		        }
		    }
		}
		public static function clinicaConteudo(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $clinica = Load::model('noticiasyeventos')->clinica($areas_id, $idiomas_id);
		    foreach ($clinica as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <div class="portfolio-item print">
		                <div class="portfolio">
		                    <a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" data-lightbox-gallery="portfolio">
		                        <img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"/>
		                        <div class="portfolio-overlay hvr-rectangle-out">
		                            <h2 class="margin-bottom-small">
		                                <strong style="color: #333;"><?php echo $value->titulo ?></strong>
		                            </h2>
		                            <div class="button">VER ESPECIALIDADE</div>
		                        </div>
		                    </a>
		               	</div>
		            </div>
		        <?
		        }else{ ?>
		           <div class="portfolio-item print">
		                <div class="portfolio">
		                    <a target="<?php echo $value->linkblank ?>" href="/clinica/<?php echo $value->urlpath ?>" data-lightbox-gallery="portfolio">
		                        <img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>"/>
		                        <div class="portfolio-overlay hvr-rectangle-out">
		                            <h2 class="margin-bottom-small">
		                                <strong style="color: #333;"><?php echo $value->titulo ?></strong>
		                            </h2>
		                            <div class="button">VER ESPECIALIDADE</div>
		                        </div>
		                    </a>
		               	</div>
		            </div>
		        <?
		        }
		    }
		}
		public static function empresarial(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $empresarial = Load::model('noticiasyeventos')->empresarial($areas_id, $idiomas_id);
		    foreach ($empresarial as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title="<?php echo $value->titulo ?>"><img src="<?php echo $value->miniatura ?>" alt="" width="100%"></a>
		        <?
		        }else{ ?>
		           <a target="<?php echo $value->linkblank ?>" href="<?php echo 'analisedasaude/'.$value->urlpath ?>" title="<?php echo $value->titulo ?>"><img src="<?php echo $value->miniatura ?>" alt="" width="100%"></a>
		        <?
		        }
		    }
		}
		public static function ClubVantagens(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $clubVantagens = Load::model('noticiasyeventos')->clubVantagens($areas_id, $idiomas_id);
		    foreach ($clubVantagens as $key => $value) {
		        if ($value->redireccionar == 1) { ?>
		            <li class="col-md-3">
						<div class="thumbnail">
							<div class="caption" style="display: none;">
								<h4><?php echo $value->titulo ?></h4>
								<p><?php echo $value->resumen ?></p>
								<a target="<?php echo $value->linkblank ?>" href="<?php echo $value->linkurl ?>" title=""><img src="/img/enviar.png" alt="Ir pará  <?php echo $value->titulo ?>"></a>
							</div>
							<img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>">
						</div>
						<!--<h4>Item Name</h4>-->
					</li>
		        <?
		        }else{ ?>
		           <li class="col-md-3">
						<div class="thumbnail">
							<div class="caption" style="display: none;">
								<h4><?php echo $value->titulo ?></h4>
								<p><?php echo $value->resumen ?></p>
								<a target="<?php echo $value->linkblank ?>" href="/club-vantagens/<?php echo $value->urlpath ?>" title=""><img src="/img/enviar.png" alt="Ir pará <?php echo $value->titulo ?>"></a>
							</div>
							<img src="<?php echo $value->miniatura ?>" alt="<?php echo $value->titulo ?>">
						</div>
						<!--<h4>Item Name</h4>-->
					</li>
		        <?
		        }
		    }
		}
		public static function propaganda(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $clubVantagens = Load::model('enlaces')->propagandaAll($areas_id, $idiomas_id);
		    foreach ($clubVantagens as $key => $value) { ?>
		        	<div class="col-xs-6 col-md-3">
						<a target="<?php echo $value->target ?>" href="<?php echo $value->url ?>" title="<?php echo $value->nombre ?>" class="thumbnail">
							<img src="<?php echo $value->miniatura ?>" alt="Ir pará  <?php echo $value->nombre ?>">
						</a>
					</div>
		    <?php
		    }
		}
		public static function propagandaTop(){
	        $areas_id = 1;
	        $idiomas_id = 1;
	        $propagandaTop = Load::model('enlaces')->propagandaTop($areas_id, $idiomas_id);
		    foreach ($propagandaTop as $key => $value) { ?>
		    	<li>
		    		<a target="<?php echo $value->target ?>" href="<?php echo $value->url ?>" title="<?php echo $value->nombre ?>">
						<img class="img-responsive" src="<?php echo $value->miniatura ?>" alt="Ir pará  <?php echo $value->nombre ?>">
					</a>
				</li>
		    <?php
		    }
		}
		public  static function contato(){ ?>
			<div class="container">
				<div class="row">
					<div class="contact-caption clearfix">
						<div class="contact-heading text-center">
							<h2>Contato</h2>
						</div>
						<div class="col-md-5 contact-info text-left">
							<h3>Informação de Contato</h3>
							<div class="col-xs-10 col-sm-10 col-md-10">
								<div class="info">
									<h5>Ligue-nos</h5><br>
									<dd>(75) 3414-2018</dd>
								</div>
								<div class="info">
									<h5>Watsapp</h5><br>
									<dd>(75) 9 91160476</dd>
								</div>
								<div class="info">
									<h5>Encontre-nos</h5><br>
									<dd>Rua Plácido Pita, 50 , Capoeirocu – Cachoeira-BA</dd>
								</div>
								<div class="info">
									<h5>E-mail</h5><br>
									<dd>contato@prosaudeintegral.com.br</dd>
									<dd>secretaria@prosaudeintegral.com.br</dd>
									<dd>administrativo@prosaudeintegral.com.br</dd>
								</div>
							</div>
							<div class="col-md-2 hidden-xs">
								<div class="info-detail">
									<ul><li><i class="fa fa-phone"></i></li></ul>
									<ul><li><i class="fa fa-whatsapp"></i></li></ul>
									<ul><li><i class="fa fa-map-marker"></i></li></ul>
									<ul><li><i class="fa fa-envelope"></i></li></ul>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-md-offset-1 contact-form">
							<h3>Deixe-nos uma mensagem </h3>
							<form class="form">
								<input class="name" type="text" placeholder="Digite seu Nome">
								<input class="email" type="email" placeholder="Digite seu E-mail">
								<input class="phone" type="text" placeholder="Telefono" width="20%">
								<input class="watsap" type="text" placeholder="WatsApp">
								<textarea class="message" name="message" id="message" cols="30" rows="5" placeholder="Mensagem"></textarea>
								<input class="submit-btn" type="submit" value="ENVIAR">
								<input class="reset-btn" type="reset" value="LIMPAR">
							</form>
						</div>
					</div>
				</div>
			</div>
		<?
		}
	}
?>