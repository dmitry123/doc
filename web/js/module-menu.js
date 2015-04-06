var ModuleMenu = {
	ready: function() {
		$(".module-menu-list li[data-url]").click(function() {
			window.location.href = url($(this).data("url"));
		});
	}
};

$(document).ready(function() {
	ModuleMenu.ready();
});