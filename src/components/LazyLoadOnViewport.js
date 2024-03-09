import React, { useState, useEffect, lazy, Suspense, useRef } from "react";
import logo from "../logo.svg";

const LazyLoadedComponent = lazy(() => import("./LazyLoadedComponent")); //Lazy-loadedcomponent

const LazyLoadOnViewport = () => {
  const observerRef = useRef(null); // created reference to the element need to observe
  const [isVisible, setIsVisible] = useState(false);

  //created the observer when component is mounted
  useEffect(() => {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            setIsVisible(true);

            if (observerRef.current) {
              observer.unobserve(observerRef.current);
            }
          }
        });
      },
      {
        threshold: 0.5,
      }
    );

    if (observerRef.current) {
      observer.observe(observerRef.current);
    }
    return () => {
      //clear the observer when component is unmounted
      if (observerRef.current) {
        observer.unobserve(observerRef.current);
      }
    };
  }, []); //Dependency array is empty only once on mount

  return (
    <div>
      {/* Placeholder or loading state while component is being loaded */}
      {isVisible ? (
        <Suspense fallback={<div>Loading...</div>}>
          <LazyLoadedComponent />
        </Suspense>
      ) : (
        <div>
          <img src={logo} alt="React logo" />
          <div
            id="lazy-load-target"
            style={{ height: "100vh" }}
            ref={observerRef}
          ></div>
        </div>
      )}
    </div>
  );
};

export default LazyLoadOnViewport;
