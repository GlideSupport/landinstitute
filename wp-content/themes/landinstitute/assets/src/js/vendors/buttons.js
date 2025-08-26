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
	label: 'Arrow Minus',
	name: 'arrow-minus',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Arrow Plus',
	name: 'arrow-plus',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Arrow Heart Symbol',
	name: 'arrow-heart-symbol',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Arrow Pointing Top',
	name: 'arrow-pointing-top',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'Border Text Btn',
	name: 'border-text-btn',
});
wp.blocks.registerBlockStyle('core/button', {
	label: 'text link',
	name: 'text-link',
});
wp.domReady(() => {
	wp.blocks.unregisterBlockStyle('core/button', 'outline');
	wp.blocks.unregisterBlockStyle('core/button', 'fill');
});