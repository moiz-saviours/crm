import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

const Header = () => {
    const [showDropdown, setShowDropdown] = useState(false);
    const { auth } = usePage().props;
    const user = auth?.user;

    const toggleDropdown = () => {
        setShowDropdown(!showDropdown);
    };

    return (
        <>
            <header className="main_header">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-md-2 d-flex">
                            <div className="logo_icon">
                                <img src="/images/logo_icon.png" alt=" logo icon"/>
                            </div>
                            <div className="img_box d-flex">
                                <img src="/images/logo.png" alt="header logo"/>
                                <span>Trello</span>
                            </div>
                        </div>

                        <div className="col-md-8 d-flex align-items-center">
                            <div className="search_sec d-flex align-items-center gap-2 flex-grow-1">
                                <i className="fas fa-search"></i>
                                <input type="text" placeholder="Search" className="form-control" style={{minWidth: 0}}/>
                            </div>
                            <button className="header_btn ml-2">Create</button>
                        </div>

                        <div className="col-md-2">
                            <div className="icon_sec d-flex position-relative">
                                <i className="fa-solid fa-bullhorn"></i>
                                <i className="fa-solid fa-bell"></i>
                                <i className="fa-solid fa-circle-question"></i>

                                <span onClick={toggleDropdown} className="user-initial">
                                {/*{user?.name?.charAt(0).toUpperCase()}*/} H
                            </span>

                                {showDropdown && (
                                    <div className="dropdown-menu header_profile show">
                                        <div className="profile_sec">
                                            <span>ACCOUNT</span>
                                            <div className="head_sec d-flex">
                                                {/*<span>{user?.name?.charAt(0).toUpperCase()}</span>*/}
                                                {/*<div className="name_sec">*/}
                                                {/*    <h3>{user?.name}</h3>*/}
                                                {/*    <p>{user?.email}</p>*/}
                                                {/*</div>*/}
                                                <span>H</span>
                                                <div className="name_sec">
                                                    <h3>hussain.khan</h3>
                                                    <p>hussain.khan@saviours.co</p>
                                                </div>
                                            </div>
                                            <ul className="profile_ul">
                                                <li><Link href="#">Switch Accounts</Link></li>
                                                <li><Link href="#">Manage Accounts</Link></li>
                                                <hr className="custom-hr"/>
                                                <li><Link href="#">Profile</Link></li>
                                                <li><Link href="#">Activity</Link></li>
                                                <li><Link href="#">Cards</Link></li>
                                                <li><Link href="#">Help</Link></li>
                                                {/*<li>*/}
                                                {/*    <Link*/}
                                                {/*        method="post"*/}
                                                {/*        href={route('logout')}*/}
                                                {/*        as="button"*/}
                                                {/*        className="logout-btn">*/}
                                                {/*        Log Out*/}
                                                {/*    </Link>*/}
                                                {/*</li>*/}
                                            </ul>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
};

export default Header;
