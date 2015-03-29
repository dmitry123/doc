var ModuleMenu = {
	ready: function() {
		$(".module-menu-heading .module-menu-title").click(function() {
			$(this).parent().find(".module-menu-list").slideToggle("normal");
		});
		$(".module-menu-list li[data-url]").click(function() {
			window.location.href = url($(this).data("url"));
		});
	}
};

$(document).ready(function() {
	ModuleMenu.ready();
});