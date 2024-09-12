/**
 * @author		Ahmed Aboelsaoud Ahmed
 * @github		https://github.com/ahmedsaoud31
 * @link		https://github.com/ahmedsaoud31/atheer
 */
var fValidationSettings = {"public_error_header": 'Please fix form validation'};

(function(){

	let fValidation = function (selector, errors) {
        return new makeValidation(selector, errors)
    }
	
	let makeValidation = function(selector = null, errors = null){
		
		// @var to save instance of this class
		let _this = {}
		_this.selector = selector
		_this.errors = errors

		/* 
		*  @function to validate form elements 
		*  @return this
		*/
		_this.validate = function(){
			let html = ''
			let public_error = ''
			let alert_sel = document.querySelector(_this.selector + ' .modal-body .alert-danger')
			if(typeof _this.errors == undefined || !_this.errors) return false
			if(Object.keys(_this.errors).length > 0){
				for (let name in _this.errors) {
					html = ''
				    if(!_this.errors.hasOwnProperty(name)) continue
					try {
						sel = document.querySelector(_this.selector + ' [name='+ name +']')
					    if(sel){
					    	sel.classList.add('is-invalid')
					    	loadElements(sel, name)
					    }
					    sel = document.querySelector(_this.selector + ' [data-name='+ name +']')
					    if(sel){
						    _this.errors[name].forEach(function(value){
						    	html += '<div>' + value + '</div>'
						    });
						    sel.innerHTML = html
						    sel.style.display = 'block'
					    }
					} catch (error) {
						public_error += '<ul><li>'+ _this.errors[name] +'</li></ul>'
					}
				    if(name == 'public'){
				    	public_error += '<ul><li>'+ _this.errors[name] +'</li></ul>'
				    }
				}
			    if(alert_sel){
			    	alert_sel.classList.remove('d-none')
			    	alert_sel.classList.add('d-block')
			    	alert_sel.innerHTML = fValidationSettings.public_error_header + public_error
			    }
			}else{
			    if(alert_sel){
			    	alert_sel.classList.remove('d-block');
			    	alert_sel.classList.add('d-none');
			    	alert_sel.innerHTML = ""
			    }
			}
			return _this
		}
		
		_this.setPublicErrorHeader = function(text){
			fValidationSettings.public_error_header = text
			return _this
		}

		function loadElements(input, name){
			input.onmouseup = function(){
				clearInvaild(name)
			}
			input.onchange = function(){
				clearInvaild(name)
			}
			input.onkeyup = function(){
				clearInvaild(name)
			}
		}

		function clearInvaild(name){
		    sel = document.querySelector(_this.selector + ' [name='+ name +']')
		    if(sel){
		    	sel.classList.remove('is-invalid')
		    }
		    sel = document.querySelector(_this.selector + ' [data-name='+ name +']')
		    if(sel){
			    sel.innerHTML = ''
			    sel.style.display = 'none'
		    }
		}

		return _this
	}
	
	if(!window.fValidation) {
		window.fValidation = fValidation
	}
	
})(document)