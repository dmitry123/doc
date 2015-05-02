
var Plantation_Master_ModuleMenu = {
	ready: function() {
		$("#plantation-master-menu").on("click", "li > a", function() {
			console.log(this);
		});
	}
};

$(document).ready(function() {
	Plantation_Master_ModuleMenu.ready();
});