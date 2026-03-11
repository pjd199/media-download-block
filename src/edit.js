import { __ } from '@wordpress/i18n';
import { 
    useBlockProps, 
    MediaUpload, 
    MediaUploadCheck, 
    InspectorControls 
} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { 
    Button, 
    PanelBody, 
    TextControl, 
    SelectControl, 
    ToggleControl,
    Flex,
    FlexItem
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const { 
        files = [], 
        headerText = 'Downloads', 
        headerLevel = 2, 
        layoutStyle = 'grid', 
        showDownloadAll = false 
    } = attributes;

    const onSelectMedia = (media) => {
        const newFiles = [...files];
        media.forEach((item) => {
            if (!newFiles.find(f => f.id === item.id)) {
                newFiles.push({
                    id: item.id,
                    url: item.url,
                    displayName: item.title,
                    fileLabel: item.subtype || item.extension,
                    fileSize: item.filesizeHumanReadable || `${(item.filesizeInBytes / 1024 / 1024).toFixed(2)} MB`,
                    realFileName: item.filename
                });
            }
        });
        setAttributes({ files: newFiles });
    };

    const updateFileName = (index, newName) => {
        const newFiles = [...files];
        newFiles[index].displayName = newName;
        setAttributes({ files: newFiles });
    };

    const removeFile = (index) => {
        const newFiles = files.filter((_, i) => i !== index);
        setAttributes({ files: newFiles });
    };

    const moveFile = (index, direction) => {
        const newFiles = [...files];
        const newIndex = index + direction;
        if (newIndex >= 0 && newIndex < newFiles.length) {
            [newFiles[index], newFiles[newIndex]] = [newFiles[newIndex], newFiles[index]];
            setAttributes({ files: newFiles });
        }
    };

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('1. Manage Files', 'mdb')} initialOpen={true}>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={onSelectMedia}
                            multiple={true}
                            render={({ open }) => (
                                <Button 
                                    isPrimary 
                                    onClick={open} 
                                    style={{ marginBottom: '20px', width: '100%', justifyContent: 'center' }}
                                >
                                    {__('Add / Select Files', 'mdb')}
                                </Button>
                            )}
                        />
                    </MediaUploadCheck>

                    {files && files.length > 0 && (
                        <div className="mdb-sidebar-management">
                            {files.map((file, index) => (
                                <div key={index} style={{ 
                                    padding: '12px 0', 
                                    borderBottom: '1px solid #e0e0e0',
                                    display: 'flex',
                                    flexDirection: 'column',
                                    gap: '8px'
                                }}>
                                    <TextControl
                                        label={__('Display Name', 'mdb')}
                                        value={file.displayName}
                                        onChange={(val) => updateFileName(index, val)}
                                        hideLabelFromVision
                                        placeholder={__('Enter display name...', 'mdb')}
                                    />
                                    
                                    <Flex justify="flex-start" gap="2">
                                        <FlexItem>
                                            <Button 
                                                isSmall 
                                                icon="arrow-up-alt2" 
                                                onClick={() => moveFile(index, -1)} 
                                                disabled={index === 0} 
                                            />
                                        </FlexItem>
                                        <FlexItem>
                                            <Button 
                                                isSmall 
                                                icon="arrow-down-alt2" 
                                                onClick={() => moveFile(index, 1)} 
                                                disabled={index === files.length - 1} 
                                            />
                                        </FlexItem>
                                        <FlexItem style={{ marginLeft: 'auto' }}>
                                            <Button 
                                                isSmall 
                                                isDestructive 
                                                icon="trash" 
                                                onClick={() => removeFile(index)} 
                                            />
                                        </FlexItem>
                                    </Flex>
                                </div>
                            ))}
                        </div>
                    )}
                </PanelBody>

                <PanelBody title={__('2. Header & Style', 'mdb')} initialOpen={false}>
                    <TextControl 
                        label={__('Header Title', 'mdb')} 
                        value={headerText} 
                        onChange={(val) => setAttributes({ headerText: val })} 
                    />
                    <SelectControl
                        label={__('Layout Type', 'mdb')}
                        value={layoutStyle}
                        options={[
                            { label: __('List View', 'mdb'), value: 'row' },
                            { label: __('Grid View', 'mdb'), value: 'grid' }
                        ]}
                        onChange={(val) => setAttributes({ layoutStyle: val })}
                    />
                    <ToggleControl 
                        label={__('Show "Download All" Button', 'mdb')} 
                        checked={showDownloadAll} 
                        onChange={(val) => setAttributes({ showDownloadAll: val })} 
                    />
                </PanelBody>
            </InspectorControls>

            {/* PREVIEW AREA */}
            <div className="mdb-preview-container">
                {files.length > 0 ? (
                    <div { ...useBlockProps({ 
                        className: `mdb-container mdb-style-${ layoutStyle }` 
                    }) }>
                        <ServerSideRender
                            block="mdb/media-download"
                            attributes={ attributes }
                        />
                    </div>
                ) : (
                    <div style={{ 
                        padding: '50px 20px', 
                        border: '2px dashed #ddd', 
                        borderRadius: '8px',
                        textAlign: 'center',
                        color: '#757575'
                    }}>
                        <p style={{ margin: 0, fontWeight: '500' }}>
                            {__('No files selected. Add them in the sidebar settings.', 'mdb')}
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
}