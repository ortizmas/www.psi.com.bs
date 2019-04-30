<?php
Load::model('areas');
class UtilesController extends AdminController{
    
	
	 protected function after_filter() {
        if (Input::isAjax()) {
            View::select(NULL, NULL);
        }
    }

    public function index() {
        try {
			
        	View::template('backend/change');
							
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }
    public function getsitios($campus){
        
            View::select(NULL, NULL);
            
        if(!empty($campus)){
            $Areas = new Areas();
            $sitios = $Areas->buscar($campus);
		?>
        <select name="change_sitio" id="change_sitio" style="display: none; ">
           <option value="">Selecciona un sitio</option>
           <?php foreach($sitios as $sitio): ?> 
           <option value="<?php echo $sitio->id ?>"><?php echo utf8_encode($sitio->nombre); ?> - <?php echo utf8_encode($sitio->titulo); ?></option> 
           <?php endforeach; ?>
        </select>
        
        <script>
		
		$(function(){
			
			$('select#change_sitio').selectmenu({
				width: 300,
				format: addressFormatting
			});
			
			$('ul.ui-selectmenu-menu').css('z-index','9999');
		});
		var addressFormatting = function(text){
			var newText = text;
			var findreps = [
				{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
				{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
				{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
				{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
			];
			
			for(var i in findreps){
				newText = newText.replace(findreps[i].find, findreps[i].rep);
			}
			return newText;
		}
		</script>
        <?php
        }
    }
}
?>
