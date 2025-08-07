import React, { useEffect } from 'react';

const BoardCard = ({ card }) => {
    useEffect(() => {
        if (typeof window.bootstrap === 'undefined') {
            console.error('Bootstrap not loaded!');
            return;
        }
    }, []);

    const handleCardClick = () => {
        const modal = new window.bootstrap.Modal(document.getElementById('cardDetailModal'));
        modal.show();
    };

    return (
        <div
            className="board-card"
            data-id={card.id}
            onClick={handleCardClick}
            style={{cursor: "pointer"}}
        >
            <div className="board-card-img">
                <img src="/assets/images/task-management/card_img.webp" alt=""/>
            </div>
            <div className="board-content-box">
                <div className="priority_sec"></div>
                <div className="board-card-title">
                    <h3>{card.title}</h3>
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
    )
}

export default BoardCard
