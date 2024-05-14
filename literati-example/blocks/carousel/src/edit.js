/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	MediaUpload,
	MediaPlaceholder,
	RichText,
	URLInput,
	InspectorControls
  } from "@wordpress/block-editor";
  
import {
	Button,
	RangeControl,
	PanelBody
} from '@wordpress/components';

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
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( props ) {
	const { attributes, setAttributes } = props;
	const { slides, autoplaySpeed } = attributes;
	console.log(attributes, 'check data');

	const onChangeItem = ( index, field, value, subfield = false ) => {
		const newItems = [ ...slides ];
		if ( ! subfield ) {
			newItems[index][field] = value;
		} else {
			newItems[index][field][subfield] = value;
		}
		setAttributes( { slides: newItems } );
	}

	const removeItem = ( index ) => {
		const newItems = [ ...slides ];
		newItems.splice( index, 1 );
		setAttributes( { slides: newItems } );
	};

	const addItem = () => {
		setAttributes( {
			slides: [
				...slides,
				{ 
					image: {
						url: "",
						alt: ""
					},
					heading: "",
					content: "",
					link: {
						text: "",
						url: ""
					}
				}
			]
		} );
	};
	
	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title="Carousel Settings">
					<RangeControl
						label="Autoplay Speed (ms)"
						value={ autoplaySpeed }
						onChange={ value => setAttributes( { autoplaySpeed: value } ) }
						min={ 1000 }
						max={ 10000 }
						step={ 200 }
					/>
				</PanelBody>
			</InspectorControls>

			<div className="carousel-items">
				{ slides && slides.map( ( slide, index ) => (
					<div className="carousel-item">
						<MediaUpload
							allowedTypes={ ['image'] }
							value={ slide.image }
							onSelect={ media => onChangeItem( index, 'image', media.url, 'url' ) }
							render= { () => (
								<div className="carousel-item__img">
									{ slide.image?.url && (
										<img src={ slide.image.url } />
									) }

									{ ! slide.image?.url && (
										<MediaPlaceholder
											icon="format-image"
											onSelect={ media => onChangeItem( index, 'image', media.url, 'url' ) }
											accept="image/*"
											allowedTypes={ [ 'image' ] }
											labels={ {
												title: 'Slide',
												name: 'slide'
											}}
										/>
									)}
								</div>
							) }
						/>
						<div className="carousel-item__content">
							<RichText
								tagName="h3"
								className="carousel-item__heading"
								value={ slide.heading }
								placeholder="Slide Heading"
								onChange={ value => { 
									console.log(value, 'checking head');
									onChangeItem(index, 'heading', value)
								} }
							/>
							<RichText
								tagName="p"
								className="carousel-item__text"
								value={ slide.content }
								placeholder="Slide Content"
								onChange={ value => onChangeItem(index, 'content', value) }
							/>
							<div className="carousel-item__link-box">
								<RichText
									tagName="span"
									placeholder="Add link text"
									value={ slide?.link?.text }
									onChange={ value => onChangeItem( index, 'link', value, 'text' ) }
								/>
								{ slide.link?.text?.length > 0 && (
									<URLInput
										placeholder="Add link URL"
										value={ slide?.link?.url }
										onChange={ value => onChangeItem( index, 'link', value, 'url' ) }
									/>
								) }
							</div>

							<Button  className="btn btn--remove" onClick={ () => removeItem( index ) }>
								{ __( 'Remove Item', 'literati-example' ) }
							</Button>
						</div>
					</div>
				) ) }
			</div>

			<Button className="btn btn--add" onClick={ addItem }>
				{ __( 'Add Item', 'literati-example' ) }
			</Button>
		</div>
	);
}
