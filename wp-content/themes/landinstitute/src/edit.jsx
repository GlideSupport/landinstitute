/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { InspectorControls, InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, RadioControl } from '@wordpress/components';
import Media from './components/Media.jsx';
import Popup from './components/Popup.jsx';
import DesignOption from './components/DesignOption.jsx';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param  props
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit( props ) {
	const {
		attributes,
		setAttributes,
	} = props;
	const { bgDesignType, bgWidth, ctnShape, className } = attributes;

	const myCustomClassName = className ? className : undefined;
	const myCustomWidthClass = bgWidth ? 'content-width-border editor-' + bgWidth : undefined;
	const myCustomDesignClass = bgDesignType ? 'editor-' + bgDesignType : undefined;
	const myCustomShape = ctnShape ? 'editor-' + ctnShape : undefined;
	const classes = [ myCustomWidthClass, myCustomDesignClass, myCustomClassName, myCustomShape ];
	const blockProps = useBlockProps( {
		className: classes.join( ' ' ),
	} );
	return (

		<div { ...blockProps }>

			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Container Width' ) } initialOpen={ true }>

						<PanelRow>
							<RadioControl
								help={ __( 'Please choose container width.' ) }
								selected={ bgWidth }
								options={ [

									{ label: 'Width 1280px (Default)', value: 'container-1280' },
									{ label: 'Width 1120px', value: 'container-1120' },
									{ label: 'Width 960px', value: 'container-960' },
									{ label: 'Width 800px', value: 'container-800' },
									{ label: 'Width 720px', value: 'container-720' },
								]
								}
								onChange={ ( value ) => setAttributes( {
									bgWidth: value,
								} ) }
							/>
						</PanelRow>
					</PanelBody>
					<PanelBody
						title={ __( 'Container Design' ) }
						className="dc-design-component"
						initialOpen={ true }
					>
						<DesignOption
							props={ props }
							value={ bgDesignType }
							DesignKey="bgDesignType"
							help="Click to select value"
							options={[
								{ label: 'Container Base Cream', value: 'bg-base-cream', display: 'bg-base-cream.png' },
								{ label: 'Container Butter Yellow', value: 'bg-butter-yellow', display: 'bg-butter-yellow.png' },
								{ label: 'Container Lemon Yellow', value: 'bg-lemon-yellow', display: 'bg-lemon-yellow.jpg' },
								{ label: 'Container Sunflower Yellow', value: 'bg-sunflower-yellow', display: 'bg-sunflower-yellow.png' },
								{ label: 'Container Sky Blue', value: 'bg-sky-blue', display: 'bg-sky-blue.png' },
								{ label: 'Container lilac', value: 'bg-lilac', display: 'bg-lilac.png' },
								{ label: 'Container Lime Green', value: 'bg-lime-green', display: 'bg-lime-green.jpg' },
								{ label: 'Container Primary Pink', value: 'bg-primary-pink', display: 'bg-primary-pink.jpg' },
							] }
						/>
					</PanelBody>
				</Panel>

			</InspectorControls>
			<section
				className={
					[ bgDesignType, bgWidth ].join( ' ' )
				}
			>
				<InnerBlocks />
			</section>
		</div>
	);
}
