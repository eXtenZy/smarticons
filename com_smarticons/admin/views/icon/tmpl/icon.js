/**
 * Icon javascript
 */

function setDisplay(mode) {
	Grid_text = $('grid_text');
	List_text = $('list_text');
	Grid_image = $('grid_image');
	List_image = $('list_image');
	Grid_icon = $('grid_icon');
	List_icon = $('list_icon');
	Icon_image_select = $('image_select');
	Icon_icon_select = $('icon_select');
	mode = parseInt(mode);
	switch(mode) {
		case 1:
			Grid_text.style.display = 'block';
			List_text.style.display = 'inline';
			Grid_image.style.display = 'block';
			List_image.style.display = 'inline';
			Icon_image_select.style.display = 'block';
			Grid_icon.style.display = 'none';
			List_icon.style.display = 'none';
			Icon_icon_select.style.display = 'none';
			break;
		case 2:
			Grid_text.style.display = 'none';
			List_text.style.display = 'none';
			Grid_image.style.display = 'block';
			List_image.style.display = 'inline';
			Icon_image_select.style.display = 'block';
			Grid_icon.style.display = 'none';
			List_icon.style.display = 'none';
			Icon_icon_select.style.display = 'none';
			break;
		case 3:
			Grid_text.style.display = 'block';
			List_text.style.display = 'inline';
			Grid_image.style.display = 'none';
			List_image.style.display = 'none';
			Icon_image_select.style.display = 'none';
			Grid_icon.style.display = 'none';
			List_icon.style.display = 'none';
			Icon_icon_select.style.display = 'none';
			break;
		case 4:
			Grid_text.style.display = 'block';
			List_text.style.display = 'inline';
			Grid_image.style.display = 'none';
			List_image.style.display = 'none';
			Icon_image_select.style.display = 'none';
			Grid_icon.style.display = 'block';
			List_icon.style.display = 'inline';
			Icon_icon_select.style.display = 'block';
			break;
		case 5:
			Grid_text.style.display = 'none';
			List_text.style.display = 'none';
			Grid_image.style.display = 'none';
			List_image.style.display = 'none';
			Icon_image_select.style.display = 'none';
			Grid_icon.style.display = 'block';
			List_icon.style.display = 'inline';
			Icon_icon_select.style.display = 'block';
			break;
		default:
			break;
	}
}

function changeIcon(icon_class) {
	Grid_icon = $('grid_icon');
	List_icon = $('list_icon');
	
	Grid_icon.removeAttribute('class');
	List_icon.removeAttribute('class');
	
	Grid_icon.addClass('big');
	Grid_icon.addClass('icon-'+icon_class);
	List_icon.addClass('icon-'+icon_class);
}

function enableModal(state) {
	if (state) {
		$('jform_params_newWindow').setAttribute('disabled', '');
		$('jform_params_modalWidth').removeAttribute('disabled');
		$('jform_params_modalHeight').removeAttribute('disabled');
	} else {
		$('jform_params_newWindow').removeAttribute('disabled');
		$('jform_params_modalWidth').removeAttribute('disabled');
		$('jform_params_modalHeight').removeAttribute('disabled');
	}
	
}

function enableNewWindow(state) {
	if (state) {
		$('jform_params_modalWindow').setAttribute('disabled', ''); 
		$('jform_params_modalWidth').setAttribute('disabled', '');
		$('jform_params_modalHeight').setAttribute('disabled', '');
	} else {
		 $('jform_params_modalWindow').removeAttribute('disabled');
		 
	}
}