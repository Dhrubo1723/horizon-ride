# horizon-ride

Ride Sharing Management System
HorizonRide

Group Members:
MD Araf Ul Haque Dhrubo 2021493042
N. M. Muntasirul Haque 2122102042
Rokeya Begum 2211488642


Functional Requirements:
User authentication: Users need to be able to safely create accounts, log in,logout.

Booking of Rides: Using their pickup and drop-off locations and fare that passengers want to pay for the destination.
Cancel the Rides: Passengers can cancel the rides by giving the ride numbers.
Real-time Matching: Could’t implement it .
Payment System:
Ride tracking: Couldn’t implement it .
Rating and Reviews:
System of Notification:
![image](https://github.com/user-attachments/assets/2e62905a-9a87-4bcd-ae59-6c8f3eff5626)

Non-Functional Requirements:

1. Usability Requirement: 
The system must provide all users with a simple and intuitive interface. 
• Performance Requirement: The response time for ride matching is not exceed 2 seconds. 
• Space Requirement: The system does not exceed more memory usage per session. 
3. Reliability Requirement: Couldn’t implement it.
4. Portability Requirement: 
• Windows and macOS support the system. 
• It is accessible via web browsers. 
A. Organizational Requirements:
 1. Delivery Requirement: The project was completed before the deadline but some requirements didn’t fulfill.
2. Implementation Requirement: The platform should be built using HTML, CSS, and JS for the front end and PHP and XAMPP database for the backend. 
3. Standard Requirement: Documentation will be written in New Roman font. 
B. External Requirements:
 1. Interoperability Requirement: The system couldn’t  integrate with Google Maps API for navigation and location services.
 2. Ethical Requirement: User data must not be shared with third parties without consent. 
3. Legislative Requirement: Couldn’t implement it.
![image](https://github.com/user-attachments/assets/a34d304b-946a-4ef1-8ff8-e2b923346f0c)

Implemented Design Patterns:

Singleton Design Pattern:
The Singleton Design Pattern ensures that a class has only one instance and provides a global point of access to that instance. It’s commonly used for database connections to ensure that only one connection instance exists throughout the application's lifecycle.

Factory Design Pattern:
Product (Interface): The User class (abstract class) defines the common interface that all concrete user types follow.
Concrete Product: The Driver, Passenger, and Admin classes, which are specific implementations of the User class, act as Concrete Products.
Creator (Factory Class): The UserFactory class is the Creator that defines the method to create different types of users.
Concrete Creator: The CreateUser functions inside the UserFactory class for creating Driver, Passenger, and Admin act as Concrete Creators.
![image](https://github.com/user-attachments/assets/c266780f-e7cb-4937-b19d-1d4c9a5f6202)

Class Structure:
1.	User Class:


o	Common properties and methods for both Driver and Passenger.


o	name, email, password, and phoneNumber are common to both.


o	register, login, and logout methods are also common.


2.	Driver Class:


o	Inherits from User and adds driver-specific properties (driverID, licenseNumber, vehicle, status).


o	Adds methods like acceptRide and cancelRide.


3.	Passenger Class:


o	Inherits from User and adds passenger-specific properties (passengerID).


o	Adds methods like requestRide and cancelRide.


4.	Ride Class:


o	Holds the ride details (rideID, passengerEmail, driverEmail, pickupLocation, dropLocation, fare, status).


o	This will link Passenger and Driver.So this the only change from the proposed class diagram.

1.	Payment System

 The HorizonRide platform now supports multiple secure payment methods, including credit cards, debit cards, digital wallets, and cash as an optional mode. This broad range of options ensures flexibility for users based on their preferences and convenience. The system encrypts all sensitive payment data, complying with standard security protocols to prevent fraud and unauthorized access.
![image](https://github.com/user-attachments/assets/104f6fe3-6ec4-4e94-a250-4f2f5488c3fe)

2.	Ratings and Reviews
3.	
 HorizonRide successfully implemented a two-way rating and review system where both passengers and drivers can provide feedback after each ride. Users are prompted to assign a star rating and optionally write a brief review based on their experience. These ratings are publicly visible on user profiles, helping future passengers or drivers make informed decisions when matching for rides.
![image](https://github.com/user-attachments/assets/bfa55234-3a75-48ca-8a4b-1d4f05519b71)

. User Profile:
Successfully implemented comprehensive user profiles for both passengers and drivers. During account creation, users are required to enter key details such as name, contact information, profile photo, and role (passenger or driver). Drivers also provide vehicle details and documents for verification.
![image](https://github.com/user-attachments/assets/096fdb52-6510-4469-927c-9f0fe0cd116d)


Design Pattern Implementations in HorizonRide

1. 💳 Payment System – Facade Design Pattern
Design Goal:
 Simplify and unify the complex payment operations (e.g., credit/debit cards, wallet, cash) behind a single interface.
How It Was Implemented:
 The Facade Design Pattern was used to create a PaymentFacade class that acts as a unified interface for all payment methods. Internally, it interacts with multiple subsystems such as:
●	CardPaymentService for credit/debit card processing,

●	WalletService for wallet balance checks and deductions,

●	CashPaymentHandler for cash confirmations.

Benefits:
●	Simplifies payment integration in the main booking flow.

●	Makes it easier to switch or update individual payment methods without affecting other parts of the system.

●	Hides the complexity of multiple payment processes behind a single, clean interface (PaymentFacade->processPayment()).



2. 👤 User Profile – Decorator Design Pattern
Design Goal:
 Allow dynamic addition of features (like profile photo, ride history, verification badge, etc.) to user profiles without modifying their core structure.
How It Was Implemented:
 The Decorator Design Pattern was used to build flexible user profiles. A basic UserProfile class defines core user info. Then decorators such as:
●	PhotoDecorator,

●	RideHistoryDecorator,

●	VerificationBadgeDecorator

can be wrapped around the base profile to enhance functionality dynamically.
Example:
python
CopyEdit
user = BasicUserProfile("John Doe")
user = RideHistoryDecorator(user)
user = VerificationBadgeDecorator(user)

Benefits:
●	Follows open/closed principle: You can add new features without changing existing code.

●	Great for flexible and scalable user profiles.

 
3. ⭐ Rating and Reviews – Facade Design Pattern
Design Goal:
 Unify various rating-related operations (submitting reviews, calculating average ratings, displaying feedback) under one easy-to-use interface.
How It Was Implemented:

 A ReviewFacade class was created that coordinates:
●	ReviewSubmissionService (handles review posting),

●	RatingCalculationService (computes averages),

●	ReviewDisplayService (fetches and formats feedback for display).
![image](https://github.com/user-attachments/assets/425f379d-f939-46c9-b2a9-9cb8a92a68c5)

Class Diagram vs Implementation
Matches:
1.	Payment

○	The Payment class contains attributes like paymentID, amount, paymentMethod, and a method processPayment().

○	This directly reflects the actual implementation where users can make payments using credit/debit cards, wallet, or cash.

○	Also encapsulates the Facade design pattern, making complex payment processing simple for the system to call.

2.	Review

○	The Review class includes rating, comment, and associations to author and reviewedUser, along with a method submitReview().

○	In the system, both drivers and passengers can review each other after a ride — this is implemented and uses the Facade pattern to handle review submissions seamlessly.

3.	User Profile (Passenger/User)

○	The Passenger class links to a Payment method and allows requesting/canceling rides.

○	The implementation uses the Decorator design pattern to add features like user verification and profile badges without modifying the base User class.

Sequence Diagram vs Implementation
Mismatches:
1.	Payment Integration

○	The sequence diagram shows processPayment() and confirms payment success/failure.

○	What's missing: No clear connection between successful payment and triggering the submitReview() or updating the user's ride history/profile.

2.	Review Process

○	Although "Rate Driver" and "Rate User" appear, they are shown as generic actions.

○	What's missing: No explicit call to the Review class's submitReview() method or how the system records the review (Facade logic not reflected).

3.	User Profile

○	Absent from the sequence diagram.

○	In the real system, user profile management (viewing, editing, updating ride history) is implemented.
![image](https://github.com/user-attachments/assets/63791aef-1320-44db-9c9c-512e2c70e330)

Vehicle Class
The Vehicle class allows users to manage the vehicles used for ridesharing. It includes functionalities for registering vehicles, retrieving vehicle information, and updating the vehicle status.
Ride Class
The Ride class handles the creation of ride bookings, tracks ride status, and updates ride details.
Admin Class
The Admin class is responsible for managing user accounts, rides, payments, and other administrative tasks within the system.
2. Proposed and Completed Non-Functional Requirements
Performance Requirements
The system must ensure that the vehicle, ride, and admin management systems perform within a reasonable time frame. For example, when users update a vehicle’s status or book a ride, the system should process the requests within 2 seconds.
Usability Requirements
The Vehicle, Ride, and Admin interfaces must be simple and intuitive, ensuring a seamless experience for users and administrators alike.
Reliability & Portability Requirements
The system must be robust enough to handle failures gracefully. Additionally, the platform must support both Windows and macOS, accessible through web browsers.
3. Design Patterns Implemented
Vehicle Class Design
Singleton Pattern: Ensures that there is only one instance of the vehicle management system running at a time.
Factory Pattern: Used to create vehicle objects based on the user input for vehicle types.
Ride Class Design
Observer Pattern: Used to notify passengers and drivers about ride status changes.
Strategy Pattern: Allows for different pricing strategies based on the ride distance and time.
Admin Class Design
Facade Pattern: Simplifies the interface for the administrator to perform multiple actions (e.g., user management, transaction management, etc.) in one go.

![image](https://github.com/user-attachments/assets/a66923f4-e659-47e8-bf9d-cd0fe27292df)

. Class and Sequence Diagram Explanation
The Class Diagram for Vehicle, Ride, and Admin reflects the relationships and dependencies between these entities, such as how the Admin manages the Vehicles and Rides.
The Sequence Diagram shows the flow of actions when a user books a ride, the admin processes the request, and the vehicle is assigned.


![image](https://github.com/user-attachments/assets/1936beac-fad2-486d-ad5e-60af787d61de)

