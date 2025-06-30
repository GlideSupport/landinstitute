/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { InnerBlocks } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param  root0
 * @param  root0.attributes
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */

export default function save({ attributes }) {
	const {
		anchor,
		bgImage,
		bgDesignType,
		bgWidth,
		bgBorderbottom,
		className,
		ctnShape,
	} = attributes;

	const myCustomDesignClass = bgDesignType ? bgDesignType : undefined;
	const myCustomShape = ctnShape ? ctnShape : undefined;
	const myCustomWidthClass = bgWidth ? bgWidth : undefined;
	const myCustomClassName = className ? className : undefined;
	const myCustomBorderBottom = bgBorderbottom ? bgBorderbottom : undefined;
	let myOverlayClass = '';
	let myStyle = {

	};
	if (bgImage.isOverlay) {
		myOverlayClass = 'has-overlay';
	}
	if (bgImage.url !== '') {
		myStyle = {
			backgroundImage: 'url(' + bgImage.url + ')',
		};
	}
	const classes = [myCustomDesignClass, myCustomWidthClass, myCustomClassName, myOverlayClass, myCustomShape];
	const wrapperClasses = ['wrapper', myCustomBorderBottom];

	return (

		<section id={anchor ? anchor : undefined} className={classes.join(' ')} style={myStyle} >
			<div className={wrapperClasses.join(' ')}>
				<InnerBlocks.Content />
			</div>
		</section>

	);
}
