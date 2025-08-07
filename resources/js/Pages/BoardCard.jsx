import React from 'react'

const BoardCard = () => {
    return (
        <>
            <div className="board-card" data-bs-toggle="modal" data-bs-target="#cardDetailModal"
                 style={{cursor: "pointer"}}>
                <div className="board-card-img">
                    <img src="./assets/images/task-management/card_img.webp" alt=""/>
                </div>
                <div className="board-content-box">
                    <div className="priority_sec"></div>
                    <div className="board-card-title">
                        <h3>New Card</h3>
                    </div>
                    <div className="board-card-detail d-flex">
                        <i className="fa-solid fa-eye"></i>
                        <button className="board-card-btn">
                            <i className="fa-solid fa-clock"></i> Jul 4
                        </button>
                        <i className="fa-solid fa-barcode"></i>
                        <i className="fa-regular fa-comment"> 1</i>
                        <div className="board-card-user">
                            <span>M</span>
                            <span>A</span>
                            <span>H</span>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}
export default BoardCard
