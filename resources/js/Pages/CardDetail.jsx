import React, { useEffect,useState, useRef } from 'react';
import {CKEditor} from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import EmojiPicker from 'emoji-picker-react';
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";


const CardDetail = ({description}) => {
    useEffect(() => {
        const modalElement = document.getElementById('cardDetailModal');
        if (modalElement && window.bootstrap) {
            // Pre-initialize the modal to prevent errors
            new window.bootstrap.Modal(modalElement);
        }
    }, []);

    // Attachment Select Code
    const fileInputRef = useRef(null);
    const handleFileClick = () => {
        fileInputRef.current.click();
    };

    // editing dec ckeditor open or close
    const [isEditing, setIsEditing] = useState(false);
    const [desc, setDesc] = useState(description || '');
    const [tempDesc, setTempDesc] = useState(description || '');

    const handleSave = () => {
        setDesc(tempDesc);
        setIsEditing(false);
    };

    const handleCancel = () => {
        setTempDesc(desc);
        setIsEditing(false);
    };

    //Comment js
    const [isCommentEditing, setIsCommentEditing] = useState(false);
    const [tempComment, setTempComment] = useState('');
    const [comments, setComments] = useState([]);


    const handleCommentSave = () => {
        if (tempComment.trim() !== '') {
            setComments(prev => [...prev, tempComment]);
            setTempComment('');
            setIsCommentEditing(false);
        }
    };


    const handleCommentCancel = () => {
        setTempComment('');
        setIsCommentEditing(false);
    };

    const [showEmojiPicker, setShowEmojiPicker] = useState(null); // To show/hide picker for a specific comment
    const [reactions, setReactions] = useState({}); // { index: emoji }


    // members dropdown
    const [showDropdown, setShowDropdown] = useState(false);

    const toggleDropdown = () => {
        setShowDropdown(prev => !prev);
    };

    // labels dropdown
    const [showLabelDropdown, setShowLabelDropdown] = useState(false);

    const toggleLabelDropdown = () => {
        setShowLabelDropdown(prev => !prev);
    };

    // Date dropdown
    const [showDateDropdown, setShowDateDropdown] = useState(false);
    const [startDateEnabled, setStartDateEnabled] = useState(true);
    const [dueDateEnabled, setDueDateEnabled] = useState(true);
    const [startDate, setStartDate] = useState(null);
    const [dueDate, setDueDate] = useState(new Date());
    const [startTime, setStartTime] = useState("12:00");
    const [dueTime, setDueTime] = useState("12:00");

    const toggleDateDropdown = () => {
        setShowDateDropdown(!showDateDropdown);
    };
    return (
        <>
            <div className="modal fade" id="cardDetailModal" tabIndex="-1" aria-hidden="true">
                <div className="modal-dialog modal-xl modal-dialog-centered">
                    <div className="modal-content bg-dark text-white rounded-4 overflow-hidden">

                        <div className="row card-cover">
                            <div className="col-md-4">
                                <span className="badge bg-secondary board_badge">Done <i
                                    className="fa-solid fa-angle-down"></i>
                                    </span>
                            </div>
                            <div className="col-md-4">
                                <img src="/assets/images/task-management/card_img.webp" alt="Cover Image"/>
                            </div>
                            <div className="col-md-4">
                                <div className="icon-group d-flex gap-2">
                                    <i className="fa-solid fa-bullhorn"></i>
                                    <i className="fa-regular fa-image"></i>
                                    <i className="fa-solid fa-eye"></i>
                                    <i className="fa-solid fa-ellipsis"></i>
                                    <i className="fa-solid fa-xmark" data-bs-dismiss="modal"></i>
                                </div>
                            </div>

                        </div>

                        <div className="modal-body row">

                            <div className="col-md-8  left_scroll_container">
                                <div className="card_left_box">
                                    <h5 className="d-flex card_title">
                                        <i className="fa-regular fa-circle"></i>
                                        new
                                    </h5>

                                    <div className="d-flex ">
                                        <div className="member_sec">
                                            <h5 className="">Members</h5>
                                            <div className="d-flex align-items-center gap-1">
                                                <span className="member-badge">A</span>
                                                <span className="member-badge">B</span>
                                                <span className="member-badge">C</span>
                                                <span className="add_member" onClick={toggleDropdown}>
                                                    <i className="fa-solid fa-plus"></i>
                                                </span>
                                            </div>

                                            {/* Member Dropdown menu */}
                                            {showDropdown && (
                                                <div className="member-dropdown-custom">
                                                    <div className="member-dropdown-header">
                                                        <span className="">Members</span>
                                                        <span className="close-icon" onClick={toggleDropdown}><i
                                                            className="fa-solid fa-xmark"></i></span>
                                                    </div>

                                                    <input
                                                        type="text"
                                                        className="member-search-input"
                                                        placeholder="Search members"
                                                    />

                                                    <div className="member-list-title">Card members</div>
                                                    <div className="member-list">
                                                        <div className="member-list-item">
                                                            <div className="member-avatar">H</div>
                                                            <div className="member-name">hussain.khan</div>
                                                            <div className="remove-icon"><i
                                                                className="fa-solid fa-xmark"></i></div>
                                                        </div>
                                                        <div className="member-list-item">
                                                            <div className="member-avatar">A</div>
                                                            <div className="member-name">Ashter Aoun</div>
                                                            <div className="remove-icon"><i
                                                                className="fa-solid fa-xmark"></i></div>
                                                        </div>
                                                        <div className="member-list-item">
                                                            <div className="member-avatar">M</div>
                                                            <div className="member-name">Moiz</div>
                                                            <div className="remove-icon"><i
                                                                className="fa-solid fa-xmark"></i></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            )}
                                        </div>

                                        <div className="label_sec">
                                            <h5 className="">Labels</h5>
                                            <div className="d-flex">
                                                <span className="label_btn">High</span>
                                                <span className="add_label" onClick={toggleLabelDropdown}><i
                                                    className="fa-solid fa-plus"></i></span>
                                            </div>

                                            {/* Label Dropdown menu */}
                                            {showLabelDropdown && (
                                                <div className="label-dropdown-custom">
                                                    <div className="label-dropdown-header">
                                                        <span className="">Labels</span>
                                                        <span className="close-icon" onClick={toggleLabelDropdown}><i
                                                            className="fa-solid fa-xmark"></i></span>
                                                    </div>

                                                    <input
                                                        type="text"
                                                        className="label-search-input"
                                                        placeholder="Search Label"
                                                    />

                                                    <div className="label-list-title">Labels</div>
                                                    <div className="label-list">
                                                        <div className="label-list-item">
                                                            <input type="checkbox" className="label-checkbox"/>
                                                            <span className="label-color-box"
                                                                  style={{backgroundColor: '#ae2e24'}}>High</span>
                                                        </div>
                                                        <div className="label-list-item">
                                                            <input type="checkbox" className="label-checkbox"/>
                                                            <span className="label-color-box"
                                                                  style={{backgroundColor: '#216e4e'}}>Normal</span>
                                                        </div>
                                                        <div className="label-list-item">
                                                            <input type="checkbox" className="label-checkbox"/>
                                                            <span className="label-color-box"
                                                                  style={{backgroundColor: '#e2b203'}}>Medium</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            )}
                                        </div>
                                        <div className="date_sec position-relative">
                                            <h5 className="">Due date</h5>
                                            <div className="d-flex">
                                                <span className="due_sec" onClick={toggleDateDropdown}>
                                                    <i className="fa-solid fa-clock me-1"></i> Jul 4, 12:21 PM <i
                                                    className="fa-solid fa-chevron-down"></i>
                                                </span>
                                            </div>

                                            {showDateDropdown && (
                                                <div className="calendar-dropdown-custom position-absolute">
                                                    <div className="calendar-dropdown-header">
                                                        <span className="">Dates</span>
                                                        <span className="close-icon" onClick={toggleDateDropdown}><i className="fa-solid fa-xmark"></i></span>
                                                    </div>
                                                    <div className="">
                                                        <DatePicker
                                                            selected={dueDate}
                                                            onChange={(date) => setDueDate(date)}
                                                            inline
                                                        />
                                                    </div>
                                                    <label className="date-label">Start date</label>
                                                    <div className="start_date_sec d-flex gap-2">
                                                        <input className="form-check-input" type="checkbox"
                                                               checked={startDateEnabled}
                                                               onChange={() => setStartDateEnabled(!startDateEnabled)}
                                                               id="startDateCheck"/>

                                                        {startDateEnabled && (
                                                            <div className="mt-1">
                                                                <input
                                                                    type="text"
                                                                    placeholder="DD/MM/YY"
                                                                    className="start_date_input"
                                                                    value={startDate ? startDate.toLocaleDateString("en-GB") : ""}
                                                                />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <label className="date-label">Due date</label>
                                                    <div className="start_due_sec d-flex gap-2">
                                                        <input className="form-check-input" type="checkbox"
                                                               checked={dueDateEnabled}
                                                               onChange={() => setDueDateEnabled(!dueDateEnabled)}
                                                               id="dueDateCheck"/>

                                                        {dueDateEnabled && (
                                                            <div className="mt-1">
                                                                <input
                                                                    type="text"
                                                                    placeholder="12:21 PM"
                                                                    className="due_date_input"
                                                                    value={dueDate ? dueDate.toLocaleDateString("en-GB") : ""}
                                                                    readOnly
                                                                />
                                                                <input type="text" className="due_time_sec" />

                                                            </div>
                                                        )}
                                                    </div>

                                                    <div className="date_sec_btn gap-2">
                                                        <button className="save_btn">Save</button>
                                                        <button className="remove_btn">Remove</button>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>

                                    <div className="d-flex desc_flex">
                                        <div className="desc_sec">
                                            <h5><i className="fa-solid fa-align-left me-3"></i> Description</h5>
                                        </div>
                                        {!isEditing && (
                                            <span className="desc_edit_btn"
                                                  onClick={() => setIsEditing(true)}>Edit</span>
                                        )}
                                    </div>
                                    <div className="view_desc">
                                        {isEditing ? (
                                            <div className="">
                                                <div className="custom-editor">
                                                    <CKEditor
                                                        editor={ClassicEditor}
                                                        data={tempDesc}
                                                        onChange={(event, editor) => {
                                                            const data = editor.getData();
                                                            setTempDesc(data);
                                                        }}
                                                    />
                                                </div>
                                                <div className="desc_ck_btn mt-2">
                                                    <button className="sav_btn me-2" onClick={handleSave}>Save
                                                    </button>
                                                    <button className="cancel_btn" onClick={handleCancel}>Cancel
                                                    </button>
                                                </div>

                                            </div>
                                        ) : (
                                            <div
                                                className="comment_box"
                                                dangerouslySetInnerHTML={{__html: desc}}
                                            />
                                        )}
                                    </div>

                                    {/*<div className="view_desc">*/}
                                    {/*    <p>It is a long established fact that a reader will be distracted by the readable*/}
                                    {/*        content of a page when looking at its layout. The point of using.</p>*/}
                                    {/*</div>*/}

                                    <div className="d-flex attch_flex">
                                        <div className="desc_sec ">
                                            <h5 className=""><i className="fa-solid fa-paperclip me-3"></i> Attachment
                                            </h5>
                                        </div>
                                        <span className="attch_add_btn" onClick={handleFileClick}>Add</span>
                                        <input
                                            type="file"
                                            ref={fileInputRef}
                                            style={{display: 'none'}}
                                        />
                                    </div>

                                    <div className="view_attach">
                                        <h6>Files</h6>
                                        <div className="attach_files d-flex">
                                            <div className="d-flex">
                                                <div className="attach_img">
                                                    <img src="/assets/images/task-management/card_img.webp" alt=""/>
                                                </div>
                                                <div className="attach_det">
                                                    <h6>curved5-samll.jpg</h6>
                                                    <p>Added Dec 11, 2025, 9:25 PM</p>
                                                </div>
                                            </div>
                                            <div className="attach_opt">
                                                <i className="fa-solid fa-ellipsis"></i>
                                            </div>
                                        </div>
                                        <div className="attach_files d-flex">
                                            <div className="d-flex">
                                                <div className="attach_img">
                                                    <img src="/assets/images/task-management/card_img.webp" alt=""/>
                                                </div>
                                                <div className="attach_det">
                                                    <h6>curved5-samll.jpg</h6>
                                                    <p>Added Dec 11, 2025, 9:25 PM</p>
                                                </div>
                                            </div>
                                            <div className="attach_opt">
                                                <i className="fa-solid fa-ellipsis"></i>
                                            </div>
                                        </div>


                                        <span
                                            className="all_attach_btn  d-block">View all attachments 7 (hidden)</span>
                                    </div>

                                    <div className="comment_sec">
                                        <div className="comment_head_sec d-flex">
                                            <img src="/assets/images/task-management/chat.png" alt=""/>
                                            <span>Comments and Activity</span>
                                        </div>

                                        <div className="user_comment">
                                            <div>
                                                {isCommentEditing ? (
                                                    <div>
                                                        <div className="custom-editor">
                                                            <CKEditor
                                                                editor={ClassicEditor}
                                                                data={tempComment}
                                                                onChange={(event, editor) => {
                                                                    const data = editor.getData();
                                                                    setTempComment(data);
                                                                }}
                                                            />
                                                        </div>
                                                        <div className="desc_ck_btn mt-2">
                                                            <button className="sav_btn me-2"
                                                                    onClick={handleCommentSave}>Save
                                                            </button>
                                                            <button className="cancel_btn"
                                                                    onClick={handleCommentCancel}>Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <div onClick={() => setIsCommentEditing(true)}>
                                                        <input className="comment_click" type="text"
                                                               placeholder="write a comment..."/>
                                                    </div>
                                                )}
                                            </div>
                                        </div>

                                        {/*Printed Comments Below*/}
                                        {/*{comments.length > 0 && (*/}
                                        {/*    <div className="printed_comments">*/}
                                        {/*        {comments.map((cmt, index) => (*/}
                                        {/*            <div key={index}*/}
                                        {/*                 className="single_comment d-flex align-items-center">*/}
                                        {/*                <div className="comment_avatar">*/}
                                        {/*                    <span>H</span>*/}
                                        {/*                </div>*/}
                                        {/*                <div className="comment_wrapper">*/}
                                        {/*                    <div*/}
                                        {/*                        className="comment_box"*/}
                                        {/*                        dangerouslySetInnerHTML={{__html: cmt}}*/}
                                        {/*                    />*/}
                                        {/*                    <div className="comment_actions d-flex gap-1">*/}
                                        {/*                        <button className="edit_btn">Edit*/}
                                        {/*                        </button>*/}
                                        {/*                        <button*/}
                                        {/*                            className="delete_btn">Delete*/}
                                        {/*                        </button>*/}
                                        {/*                        <button*/}
                                        {/*                            className="reaction_btn"*/}
                                        {/*                            onClick={() => setShowEmojiPicker(showEmojiPicker === index ? null : index)}*/}
                                        {/*                        >*/}
                                        {/*                            <i className="fa-regular fa-face-smile"></i>*/}
                                        {/*                        </button>*/}
                                        {/*                    </div>*/}
                                        {/*                </div>*/}
                                        {/*            </div>*/}
                                        {/*        ))}*/}
                                        {/*    </div>*/}
                                        {/*)}*/}
                                        {comments.length > 0 && (
                                            <div className="printed_comments">
                                                {comments.map((cmt, index) => (
                                                    <div key={index}
                                                         className="single_comment align-items-center">

                                                        <div className="comment_avatar d-flex">
                                                            <span>H</span>
                                                            <div className="usr_name_sec ">
                                                                <h6>hussain.khan</h6> <p>Jul 18,2025, 7:57PM </p>
                                                            </div>
                                                        </div>

                                                        <div className="comment_wrapper">
                                                            <div className="comment_box"
                                                                 dangerouslySetInnerHTML={{__html: cmt}}/>
                                                            <div
                                                                className="comment_actions d-flex gap-1">
                                                                <button className="edit_btn">Edit</button>
                                                                <button className="delete_btn"> Delete</button>

                                                                {/* Emoji shown (if any) */}
                                                                {reactions[index] && (
                                                                    <span>{reactions[index]}</span>
                                                                )}

                                                                {/* Emoji picker icon */}
                                                                <button
                                                                    className="reaction_btn"
                                                                    onClick={() =>
                                                                        setShowEmojiPicker(showEmojiPicker === index ? null : index)
                                                                    }
                                                                >
                                                                    <i className="fa-regular fa-face-smile"></i>
                                                                </button>

                                                                {/* Picker shown only for selected comment */}
                                                                {showEmojiPicker === index && (
                                                                    <div className="emoji_container">
                                                                        <button
                                                                            onClick={() => setShowEmojiPicker(index)}>
                                                                        </button>

                                                                        {showEmojiPicker === index && (
                                                                            <div className="emoji_show">
                                                                                <EmojiPicker
                                                                                    theme="dark"
                                                                                    width={300}
                                                                                    height={300}
                                                                                    emojiSize={10}
                                                                                    emojiPadding={4}
                                                                                    autoFocusSearch={false}
                                                                                    onEmojiClick={(emojiData) => {
                                                                                        const selectedEmoji = emojiData.emoji;
                                                                                        setReactions((prev) => ({
                                                                                            ...prev,
                                                                                            [index]: selectedEmoji,
                                                                                        }));
                                                                                        setShowEmojiPicker(null);
                                                                                    }}
                                                                                />
                                                                            </div>
                                                                        )}
                                                                    </div>

                                                                )}
                                                            </div>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        )}

                                    </div>
                                </div>
                            </div>

                            <div className="col-md-4">
                                <div className="card_detail_right_side">
                                    <ul className="btn_sec">
                                        <li className="detail_btn_sec"><i className="fa-solid fa-user-plus"></i>
                                            <span>Join</span></li>
                                        <li className="detail_btn_sec"><i className="fa-solid fa-user"></i>
                                            <span>Members</span></li>

                                        <li className="detail_btn_sec"><i className="fa-solid fa-tag"></i>
                                            <span>Labels</span></li>

                                        <li className="detail_btn_sec"><i className="fa-solid fa-clock"></i>
                                            <span>Date</span></li>

                                        <li className="detail_btn_sec"><i className="fa-solid fa-paperclip"></i>
                                            <span>Attachments</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}
export default CardDetail
