wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Sunflower Yellow',
	name: 'btn-sunflower-yellow',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Lilac',
	name: 'btn-lilac',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Sky Blue',
	name: 'btn-sky-blue',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Lime Green',
	name: 'btn-lime-green',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Butter Yellow',
	name: 'btn-butter-yellow',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Lemon Yellow',
	name: 'btn-lemon-yellow',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Btn Brown',
	name: 'btn-brown',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Border Text Btn',
	name: 'border-text-btn',
});
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle('core/button', 'outline');
	wp.blocks.unregisterBlockStyle('core/button', 'fill');
});