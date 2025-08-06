import React, {useState, useRef, useEffect} from 'react';
import BoardCard from '../Pages/BoardCard.jsx';
import CardDetail from '../Pages/CardDetail.jsx';

const BoardList = ({product}) => {
    const [isAddingCard, setIsAddingCard] = useState(false);
    const columnBodyRef = useRef(null);
    const wrapperRef = useRef(null);

    const handleAddClick = () => {
        setIsAddingCard(true);
    };

    const handleClose = () => {
        setIsAddingCard(false);
    };

    useEffect(() => {
        const wrapper = wrapperRef.current;
        const inputBoxExists = wrapper?.querySelector('.card-input-container');

        if (!inputBoxExists && wrapper) {
            wrapper.style.maxHeight = 'calc(400px - 34px)';
        } else if (wrapper) {
            wrapper.style.maxHeight = '';
        }

        if (isAddingCard && columnBodyRef.current) {
            // Wait for textarea to appear in DOM
            setTimeout(() => {
                columnBodyRef.current.scrollTop = columnBodyRef.current.scrollHeight;
            }, 50);
        }
    }, [isAddingCard]);

    return (
        <>
            <div className="board-position">
                <div className="board-container">
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">Done</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>

                        <div
                            className={`column-body-wrapper ${!isAddingCard ? 'adjusted-height' : ''}`}
                            ref={wrapperRef}
                        >
                            <div className="column-body" ref={columnBodyRef}>
                                {/* Cards */}
                                <BoardCard product={product}/>
                                <BoardCard product={product}/>

                                {/* Input Box */}
                                {isAddingCard && (
                                    <div className="card-input-container">
                                        <textarea
                                            className="card-input"
                                            placeholder="Enter card title..."
                                        />
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Footer */}
                        {!isAddingCard && (
                            <div className="column-footer" onClick={handleAddClick}>
                                <div className="add-card-div">
                                <span className="add-icon">
                                    <i className="fa-solid fa-plus"></i>
                                </span>
                                    <span className="add-title">Add a card</span>
                                </div>
                            </div>
                        )}
                    </div>
                    <CardDetail/>
                </div>
            </div>
        </>
    );
};

export default BoardList;
