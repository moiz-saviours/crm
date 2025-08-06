import React, {useState} from 'react'
import BoardCard from "../Pages/BoardCard.jsx";
import CardDetail from "../Pages/CardDetail.jsx";

const BoardList = (product) => {
    const [isAddingCard, setIsAddingCard] = useState(false);

    const handleAddClick = () => {
        setIsAddingCard(true);
    };

    const handleClose = () => {
        setIsAddingCard(false);
    };


    return (
        <>
            <div className="board-position">
                <div className="board-wrapper">
                    <div className="board-container">
                        <div className="board-column">
                            <div className="column-header">
                                <span className="column-title">Done</span>
                                <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                                </span>
                            </div>

                            <div className="column-body-wrapper">
                                <div className="column-body">
                                    <BoardCard product={product.product}/>
                                    <BoardCard product={product.product}/>

                                    {/* Input Box (when active) */}
                                    {isAddingCard && (<div className="card-input-container">
                                        <textarea className="card-input" placeholder="Enter card title..."/>
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>)}
                                </div>

                                {/* Always Fixed at Bottom */}
                                {!isAddingCard && (<div className="add-card" onClick={handleAddClick}>
                                        <span className="add-icon">
                                      <i className="fa-solid fa-plus"></i>
                                    </span>
                                    <span className="add-title">Add a card</span>
                                </div>)}
                            </div>
                        </div>
                        <CardDetail />
                    </div>
                </div>
            </div>
        </>
    )
}
export default BoardList
