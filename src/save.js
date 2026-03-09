import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { getFileIcon } from './utils';

/**
 * The save function defines the way in which the different attributes should be combined
 * into the final markup, which is then rendered by WordPress on the front end.
 */
export default function save({ attributes }) {
    const { files, headerText, headerLevel, layoutStyle } = attributes;

    // Define the header tag dynamically (defaulting to h2)
    const HeaderTag = `h${headerLevel || 2}`;

    // If no files are selected, render nothing
    if (!files || files.length === 0) {
        return null;
    }

    return (
        <div {...useBlockProps.save({ 
            className: `mdb-container mdb-style-${layoutStyle}` 
        })}>
            {/* Dynamic Header based on user selection */}
            {headerText && (
                <HeaderTag className="mdb-front-header">
                    {headerText}
                </HeaderTag>
            )}

            <div className="mdb-list-wrapper">
                {files.map((file, index) => (
                    <div 
                        key={file.id || index} 
                        className="mdb-download-row"
                    >
                        {/* File Icon from shared utils.js */}
                        <div className="mdb-file-icon">
                            {getFileIcon(file.fileLabel)}
                        </div>

                        {/* File details */}
                        <div className="mdb-download-details">
                            <span className="mdb-download-title">
                                {file.displayName}
                            </span>
                            <span className="mdb-download-size">
                                {file.fileSize}
                            </span>
                        </div>

                        {/* Modern Minimalist Download Link */}
                        <a 
                            href={file.url} 
                            className="mdb-clean-link" 
                            download 
                            title={__('Download File', 'mdb')}
                        >
                            <svg 
                                xmlns="http://www.w3.org/2000/svg" 
                                width="20" 
                                height="20" 
                                fill="currentColor" 
                                viewBox="0 0 16 16"
                            >
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>
                ))}
            </div>
        </div>
    );
}