import { registerBlockType } from '@wordpress/blocks';
import './style.scss'; // This stays to tell Webpack to compile the CSS
import Edit from './edit';
import save from './save';
import metadata from './block.json'; // Import the JSON

registerBlockType( metadata.name, {
    ...metadata, // Spreads all attributes/settings from block.json
    edit: Edit,
    save,
});