import React from 'react'

const Board = () => {
    return (
        <>
            <div className="banner_sec">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-md-6">
                            <div className="left_sec d-flex">
                                <h1>Development Board</h1>
                                <img src="/assets/images/task-management/board-icon.png" alt="board icon"/>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="right_sec d-flex">
                                <div className="user_sec">
                                    <span>H</span>
                                    <span>M</span>
                                    <span>A</span>
                                    <span>A</span>
                                </div>
                                <div className="board_icon_sec">
                                    <i className="fa-solid fa-rocket"></i>
                                    <i className="fa-solid fa-bolt"></i>
                                    <i className="fa-solid fa-arrow-down-wide-short"></i>
                                    <i className="fa-solid fa-star"></i>
                                    <i className="fa-solid fa-user-group"></i>
                                    <button className="shared_btn"> <i className="fa-solid fa-user-plus"></i>Share</button>
                                    <i className="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </>
    )
}
export default Board
