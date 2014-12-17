jQuery(document).ready(function(){
    var $listGenre = $('#list-genre');
	var $listGenreAdd = $('#list-genre-add');
	var $buttonAdd= $('#add-genre');
	var $buttonRemove= $('#remove-genre');
	var $itemGenreId = $('#item_genres')
	
	$buttonAdd.click(function(){
		var $idGenre = $listGenre.val();
		var $optionSelected = $('#list-genre option[value='+$idGenre+']');
		$listGenreAdd.append($optionSelected);
		if($idGenre != null){
			$itemGenreId.val($itemGenreId.val()+$idGenre+'-')
		}
		
	})
	
	$buttonRemove.click(function(){
		var $idGenre = $listGenreAdd.val();
		var $optionSelected = $('#list-genre-add option[value='+$idGenre+']');
		$listGenre.append($optionSelected);
		var $idGenres = $itemGenreId.val();
		var $nombre = "";
		for(var i = 0; i < $idGenres.length ; i++){
			if($idGenres[i] != '-'){
				$nombre += $idGenres[i];
			} else {
				if($nombre == $idGenre){
					$idGenres = $idGenres.replace($idGenres.substring(i - $nombre.length, i + 1),'');
					$itemGenreId.val($idGenres);
				}
				$nombre = "";
			}
		}
	})
});