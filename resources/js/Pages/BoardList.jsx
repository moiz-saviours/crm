import React, {useState, useRef, useEffect} from 'react';
import BoardCard from '../Pages/BoardCard.jsx';
import CardDetail from '../Pages/CardDetail.jsx';
import { Sortable } from 'sortablejs';


const BoardList = () => {
    const [isAddingCard, setIsAddingCard] = useState(false);
    const [columns, setColumns] = useState({
        done: [
            { id: 1, title: "Card 1" },
            { id: 2, title: "Card 2" }
        ],
        todo: [
            { id: 3, title: "Card 3" }
        ],
        inProgress: []
    });

    const doneRef = useRef(null);
    const todoRef = useRef(null);
    const inProgressRef = useRef(null);

    useEffect(() => {
        const initializeSortable = (ref, columnId) => {
            if (!ref.current) return;

            new Sortable(ref.current, {
                group: 'shared',
                animation: 150,
                ghostClass: 'sortable-ghost',
                fallbackOnBody: true,
                swapThreshold: 0.65,
                forceFallback: true,
                onEnd: (evt) => {
                    const { from, to, oldIndex, newIndex } = evt;
                    const fromColumn = from.id;
                    const toColumn = to.id;

                    if (!fromColumn || !toColumn || oldIndex === undefined || newIndex === undefined) return;

                    setColumns(prev => {
                        const newColumns = { ...prev };
                        const movedItem = newColumns[fromColumn][oldIndex];

                        // Remove from old column
                        newColumns[fromColumn] = [...newColumns[fromColumn]];
                        newColumns[fromColumn].splice(oldIndex, 1);

                        // Add to new column
                        newColumns[toColumn] = [...newColumns[toColumn]];
                        newColumns[toColumn].splice(newIndex, 0, movedItem);

                        return newColumns;
                    });

                    // Revert DOM change, React will re-render correctly
                    evt.from.insertBefore(evt.item, evt.from.children[oldIndex]);
                }
            });
        };


        initializeSortable(doneRef, 'done');
        initializeSortable(todoRef, 'todo');
        initializeSortable(inProgressRef, 'inProgress');

        return () => {
            // Cleanup Sortable instances if needed
            [doneRef, todoRef, inProgressRef].forEach(ref => {
                if (ref.current?.sortable) {
                    ref.current.sortable.destroy();
                }
            });
        };
    }, []);

    const handleAddClick = () => setIsAddingCard(true);
    const handleClose = () => setIsAddingCard(false);

    return (

        <div className="board-position">
            <div className="board-wrapper">
                <div className="board-container">
                    {/* Done Column */}
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">Done</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="done" ref={doneRef}>
                                {columns.done.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                                {isAddingCard && (
                                    <div className="card-input-container">
                                        <textarea className="card-input" placeholder="Enter card title..."/>
                                        <div className="card-input-actions">
                                            <button className="add-card-btn">Add Card</button>
                                            <button className="close-card-btn" onClick={handleClose}>
                                                <i className="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                            {!isAddingCard && (
                                <div className="add-card" onClick={handleAddClick}>
                                    <span className="add-icon">
                                        <i className="fa-solid fa-plus"></i>
                                    </span>
                                    <span className="add-title">Add a card</span>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">Todo</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="todo" ref={todoRef}>
                                {columns.todo.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* In Progress Column */}
                    <div className="board-column">
                        <div className="column-header">
                            <span className="column-title">In Progress</span>
                            <span className="column-menu">
                                <i className="fa-solid fa-ellipsis"></i>
                            </span>
                        </div>
                        <div className="column-body-wrapper">
                            <div className="column-body" id="inProgress" ref={inProgressRef}>
                                {columns.inProgress.map(card => (
                                    <BoardCard key={card.id} card={card}/>
                                ))}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    );
};

export default BoardList;
