
/**
 * Register block styles
 */

wp.domReady(()=>{
	/*** core/button ***/
	wp.blocks.unregisterBlockStyle('core/button', 'fill');
	wp.blocks.unregisterBlockStyle('core/button', 'outline');

	/*** core/separator ***/
	wp.blocks.unregisterBlockStyle('core/separator', 'default');
	wp.blocks.unregisterBlockStyle('core/separator', 'wide');
	wp.blocks.unregisterBlockStyle('core/separator', 'dots');

	// Register styles
	const styles = {
		'core/button': [
			{name: 'outline', label: 'Outline'},
			{name: 'arrow', label: 'Arrow'}
		],
		'core/column': [
			{name: 'sticky', label: 'Stick to top'},
		],
		'lightweight-accordion/lightweight-accordion': [
			{name: 'chat-text', label: 'Chat text'}
		]
	};
	Object.keys(styles).forEach(key => {
		styles[key].forEach((item)=>{
			wp.blocks.registerBlockStyle(
				key, {
					name: item.name,
					label: item.label,
				}
			);
		});
	});
});
