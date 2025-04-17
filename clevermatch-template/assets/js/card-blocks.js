(function(blocks, element, blockEditor) {
		var el = element.createElement;
		var InnerBlocks = blockEditor.InnerBlocks;
		
		blocks.registerBlockType('custom/card', {
				title: 'Content Card',
				icon: el('svg', 
						{ 
								xmlns: "http://www.w3.org/2000/svg",
								height: 24,
								viewBox: "0 0 24 24",
								width: 24,
								fill: "#000000",
								'aria-hidden': "true",
								focusable: "false"
						},
						[
								el('path', {
										d: "M0 0h24v24H0V0z",
										fill: "none"
								}),
								el('path', {
										d: "M18 4H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H6V6h12v12z"
								})
						]
				),
				category: 'design',
				
				attributes: {
						className: {
								type: 'string'
						}
				},
				
				edit: function(props) {
						const { className } = props.attributes;
						return el(
								'div',
								{ className: `card mb-4 ${className || ''}` },
								el(
										'div',
										{ className: 'card-body' },
										el(InnerBlocks, {
												allowedBlocks: [
														'core/heading', 
														'core/paragraph', 
														'core/pullquote', 
														'core/image', 
														'core/list', 
														'core/columns',
														'core/html',
														'core/shortcode',
														'core/spacer'
												],
												template: [
														['core/heading', { level: 3, placeholder: 'Card Überschrift...' }],
														['core/paragraph']
												],
												templateLock: false
										})
								)
						);
				},
				
				save: function(props) {
						return el(InnerBlocks.Content);
				}
		});
}(
		window.wp.blocks,
		window.wp.element,
		window.wp.blockEditor
));
