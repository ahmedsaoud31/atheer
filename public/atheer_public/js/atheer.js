/**
 * @author		Ahmed Aboelsaoud Ahmed
 * @github		https://github.com/ahmedsaoud31
 * @link		https://github.com/ahmedsaoud31/atheer
 */
class Atheer
{
	static togglePassword(element) {
		if(element.previousElementSibling.type == 'password'){
			element.previousElementSibling.type = 'text';
			element.children[0].classList.add('d-none');
			element.children[1].classList.remove('d-none');
		}else{
			element.previousElementSibling.type = 'password';
			element.children[0].classList.remove('d-none');
			element.children[1].classList.add('d-none');
		}
	}
}

window.onload = function() {
	if(!window.Atheer) {
		window.Atheer = Atheer;
	}
};