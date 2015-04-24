var ModuleMenu = {
	ready: function() {
		$(".module-menu-list li[data-url]").click(function() {
			window.location.href = url($(this).data("url"));
		});
		//$(".module-menu-title").mouseenter(function() {
		//	$(this).find(".module-menu-block").fadeToggle("fast");
		//}).mouseleave(function() {
		//	$(this).find(".module-menu-block").fadeToggle("fast");
		//});
	}
};

$(document).ready(function() {
	ModuleMenu.ready();
});