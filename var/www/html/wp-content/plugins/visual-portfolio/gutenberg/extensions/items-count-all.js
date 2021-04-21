/**
 * External dependencies
 */
import classnames from 'classnames/dedupe';

/**
 * Internal dependencies
 */
import controlGetValue from '../utils/control-get-value';

/**
 * WordPress dependencies
 */
const {
    __,
} = wp.i18n;

const {
    addFilter,
} = wp.hooks;

const {
    RawHTML,
    Fragment,
} = wp.element;

const {
    BaseControl,
    ButtonGroup,
    Button,
    TextControl,
} = wp.components;

// Items count with "All Items" button.
addFilter( 'vpf.editor.controls-render', 'vpf/editor/controls-render/customize-controls', ( render, data ) => {
    if ( 'items_count' === data.name ) {
        const {
            description,
            attributes,
            onChange,
        } = data;

        const renderControlHelp = description ? <RawHTML>{ description }</RawHTML> : false;
        const renderControlClassName = classnames( 'vpf-control-wrap', `vpf-control-wrap-${ data.type }` );
        const controlVal = parseInt( controlGetValue( data.name, attributes ), 10 );

        render = (
            <BaseControl
                label={ data.label }
                help={ renderControlHelp }
                className={ renderControlClassName }
            >
                <div>
                    <ButtonGroup>
                        <Button
                            isSmall
                            isPrimary={ -1 !== controlVal }
                            isPressed={ -1 !== controlVal }
                            onClick={ () => {
                                if ( -1 === controlVal ) {
                                    onChange( parseFloat( data.default || 6 ) );
                                }
                            } }
                        >
                            { __( 'Custom Count', 'visual-portfolio' ) }
                        </Button>
                        <Button
                            isSmall
                            isPrimary={ -1 === controlVal }
                            isPressed={ -1 === controlVal }
                            onClick={ () => {
                                // eslint-disable-next-line no-alert
                                if ( -1 !== controlVal && window.confirm( __( 'Be careful, the output of all your items can adversely affect the performance of your site, this option may be helpful for image galleries.', 'visual-portfolio' ) ) ) {
                                    onChange( -1 );
                                }
                            } }
                        >
                            { __( 'All Items', 'visual-portfolio' ) }
                        </Button>
                    </ButtonGroup>
                </div>
                { -1 !== controlVal ? (
                    <Fragment>
                        <br />
                        <TextControl
                            type="number"
                            min={ data.min }
                            max={ data.max }
                            step={ data.step }
                            value={ controlVal }
                            onChange={ ( val ) => onChange( parseFloat( val ) ) }
                        />
                    </Fragment>
                ) : '' }
            </BaseControl>
        );
    }

    return render;
} );
