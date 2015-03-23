var ModuleMenu = {
	ready: function() {
		$(".module-menu-heading .module-menu-title").click(function() {
			$(this).parent().find(".module-menu-list").slideToggle("normal");
		});
	}
};

$(document).ready(function() {
	ModuleMenu.ready();
});