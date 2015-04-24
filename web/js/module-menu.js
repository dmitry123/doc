var ModuleMenu = {
	ready: function() {
		$(".module-menu-list li[data-url], .module-menu-block-icon-wrapper[data-url]").click(function() {
			window.location.href = url($(this).data("url"));
		});
	}
};

$(document).ready(function() {
	ModuleMenu.ready();
});