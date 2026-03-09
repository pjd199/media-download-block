import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import save from './save';

registerBlockType( 'wpdm/media-download', {
    title: 'Media Download', // This is what shows in the block inserter
    icon: 'download',
    category: 'common',
    attributes: {
        mediaID: { type: 'number' },
        mediaURL: { type: 'string' },
        mediaTitle: { type: 'string' },
        mediaSize: { type: 'string' },
        fileLabel: { type: 'string', default: 'FILE' },
        customName: { type: 'string', default: '' }
    },
    edit: Edit,
    save,
});
