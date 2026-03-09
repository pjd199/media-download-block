import { __ } from '@wordpress/i18n';

/**
 * Returns a Bootstrap SVG Icon path based on file extension.
 * @param {string} label - The file extension (e.g. 'PDF', 'JPG').
 * @returns {JSX.Element} SVG Component.
 */
export const getFileIcon = (label) => {
    const ext = label ? label.toLowerCase() : '';
    
    // Default File Icon (Standard Page)
    let path = <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5L9.5 1z"/>;

    if (['jpg', 'jpeg', 'png', 'gif', 'svg'].includes(ext)) {
        path = <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>;
    } else if (ext === 'pdf') {
        path = <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM4.5 12.5a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zm0-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1z"/>;
    } else if (['doc', 'docx', 'txt'].includes(ext)) {
        path = <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m9-3.5a.5.5 0 0 0-1 0V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>;
    } else if (['zip', 'rar', '7z'].includes(ext)) {
        path = <path d="M6.5 7.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m2 2a1 1 0 1 1 0-2 1 1 0 0 1 0 2m1 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>;
    } else if (['mp4', 'mov', 'avi'].includes(ext)) {
        path = <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zm-2 3v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z"/>;
    } else if (['mp3', 'wav'].includes(ext)) {
        path = <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m7.132 6.213a.5.5 0 0 1 .62.395l.74 3.903a1.5 1.5 0 1 1-.985.3l-.627-3.307a.5.5 0 0 1 .252-.691z"/>;
    } else if (['xls', 'xlsx', 'csv'].includes(ext)) {
        path = <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM5.184 12.14l1.671-2.621-1.455-2.12h1.143l.857 1.481.847-1.481h1.13l-1.427 2.14 1.667 2.601h-1.19l-1.037-1.745-1.027 1.745z"/>;
    } else if (['ppt', 'pptx'].includes(ext)) {
        path = <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5zM7 11.586V13h-.99V7h1.69c.944 0 1.591.563 1.591 1.446 0 .894-.647 1.464-1.604 1.464zM7 7.82v2.859h.6c.58 0 .918-.322.918-.748 0-.429-.333-.711-.904-.711z"/>;
    }

    return (
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            {path}
        </svg>
    );
};