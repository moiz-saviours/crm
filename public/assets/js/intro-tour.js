// Tour configurations
const tours = {
    dashboard1: {
        steps: [
            {
                element: '.tour-dashboard1-alldata',
                intro: "This section displays a quick overview of the CRM's total performance for the current month.",
                position: 'right'
            },
            {
                element: '.tour-dashboard1-admin',
                intro: "Shows the number of currently active admin users.",
                position: 'top'
            },
            {
                element: '.tour-dashboard1-user',
                intro: "Displays the number of employees actively using the system.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-freshinvoice',
                intro: "Total amount generated from newly created fresh invoices this month.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-upsaleinvoice',
                intro: "Total amount generated from upsell invoices this month.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-invoicedata',
                intro: "Sum of all total invoices PAID,DUE,REFUND,CHARGEBACK",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-monthlydata',
                intro: "Shows date-wise payment received for the current month.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-annualdata',
                intro: "Displays total payment received each month throughout the current year.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-recenpayment',
                intro: "List of most recent payments received for this month in the CRM.",
                position: 'top'
            }
            ,
            {
                element: '.tour-dashboard1-leadprogress',
                intro: "Visual chart showing lead for this month counts by status like New, Contracted, Qualified, etc.",
                position: 'left'
            }
            ,
            {
                element: '.tour-dashboard1-paymentprogress',
                intro: "Shows the count of Paid, Refunded, and Chargeback transactions this month.",
                position: 'left'
            }
            ,
            {
                element: '.tour-dashboard1-overallprogress',
                intro: "Displays total counts of leads, customers, invoices, and payments. Hover over each section for exact numbers for this month",
                position: 'left'
            }
        ],

    },
    dashboard2: {
        steps: [
            {
                element: '.tour-dashboard2-alldata',
                intro: "All data overview for all Teams and all Brands ",
                position: 'right'
            },
            {
                element: '.tour-team-select',
                intro: 'Choose a specific team to filter data .',
                position: 'bottom',
            },
            {
                element: '.tour-brand-select',
                intro: "After selecting a team, pick a brand to view its related metrics.",
                position: 'bottom'
            },
            {
                element: '.tour-date-select',
                intro: "Set a custom date range to view data for a specific time period.",
                position: 'bottom'
            },
            {
                element: '.tour-totalsales-select',
                intro: "Displays the total sales amount for the selected filters.",
                position: 'bottom'
            },
            {
                element: '.tour-totalcash-select',
                intro: "Shows the total amount of cash received.",
                position: 'bottom'
            },
            {
                element: '.tour-refund-select',
                intro: "Total amount refunded or charged back.",
                position: 'bottom'
            },
            {
                element: '.tour-charge-select',
                intro: "Indicates the percentage of chargebacks against total sales.",
                position: 'bottom'
            },
            {
                element: '.tour-reversals-select',
                intro: "Shows the number of reversed transactions.",
                position: 'bottom'
            },
            {
                element: '.tour-netcash-select',
                intro: "Net cash after adjusting for refunds and chargebacks.",
                position: 'bottom'
            },
            {
                element: '.tour-targetvsachieved-select',
                intro: "Compares target goals with actual sales.",
                position: 'right'
            },
            {
                element: '.tour-mtd-select',
                intro: "Month-to-Date progress and last approved figures.",
                position: 'right'
            },
            {
                element: '.tour-upsell-select',
                intro: "Revenue earned from additional sales beyond initial transactions.",
                position: 'right'
            },
            {
                element: '.tour-account-select',
                intro: "Number of accounts involved during the selected timeframe.",
                position: 'right'
            },
            {
                element: '.tour-teamrecord-select',
                intro: "Shows team performance for current month team total target and achieved",
                position: 'right'
            },
            {
                element: '.tour-userecord-select',
                intro: "Displays individual user performance of individual Team",
                position: 'left'
            },
        ],
    },

    admins: {
        steps: [
            {
                element: '.tour-admintitle',
                intro: "Admin related Data",
                position: 'right'
            },
            {
                element: '.tour-adminalldata',
                intro: "This table displays all admin data like name, email, designation, status.",
                position: 'top'
            },
            {
                element: '.tour-adminaction',
                intro: "Use these actions to manage admin data. like generate password , edit & delete admin",
                position: 'top'
            },


        ],

    },
    admincreate: {
        steps: [
            {
                element: '.tour-createadmin',
                intro: "Click to create a admin",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-admincreation',
                intro: "You can create or edit a admin",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-adminname',
                intro: "Enter the admin full name.",
                position: 'left',

            },
            {
                element: '.tour-adminpseudoname',
                intro: "Enter the admin pseudo name.",
                position: 'left',
            },

            {
                element: '.tour-adminemail',
                intro: "Enter the admin email address.",
                position: 'left',
            },
            {
                element: '.tour-adminpseudoemail',
                intro: "Enter the admin pseudo email address.",
                position: 'left',

            },

            {
                element: '.tour-admindesignation',
                intro: "Mention the admin job title.",
                position: 'left',

            },
            {
                element: '.tour-admingender',
                intro: "Select the admin gender.",
                position: 'left',

            },
            {
                element: '.tour-adminphone',
                intro: "Enter the contact number.",
                position: 'left',

            },
            {
                element: '.tour-adminaddress',
                intro: "Enter the full address.",
                position: 'left',

            },
            {
                element: '.tour-adminimage',
                intro: "Upload the admin’s profile picture.",
                position: 'left',

            },
            {
                element: '.tour-adminpassword',
                intro: "Manually set or auto-generate the password.",
                position: 'left',

            },
            {
                element: '.tour-adminstatus',
                intro: "Set as Active or Inactive.",
                position: 'left',

            },
            {
                element: '.tour-adminsubmit',
                intro: "Click & create admin",
                position: 'left',

            },


        ],

    },

    employee: {
        steps: [
            {
                element: '.tour-employeetitle',
                intro: "Employees related Data",
                position: 'right'
            },
            {
                element: '.tour-employeealldata',
                intro: "This table displays all admin data like name, email, designation, status.",
                position: 'top'
            },
            {
                element: '.tour-employeeaction',
                intro: "Use these actions to manage employee data. like generate password , edit & delete admin",
                position: 'top'
            },


        ],

    },
    employeecreate: {
        steps: [
            {
                element: '.tour-createmployee',
                intro: "Click to create a Employee",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-employeecreation',
                intro: "You can create or edit a employee",
                position: 'left',
                hideBack: true

            },
            {
                element: '.tour-employeedepartment',
                intro: "Choose the employee department.",
                position: 'left',

            },
            {
                element: '.tour-employeerole',
                intro: " Assign a role to the employee.",
                position: 'left',

            },

            {
                element: '.tour-employeeposition',
                intro: "Choose the employee position.",
                position: 'left',

            },
            {
                element: '.tour-employeeteam',
                intro: "Assign the employee to a team.",
                position: 'left',

            },
            {
                element: '.tour-employeeid',
                intro: "Enter the unique employee ID.",
                position: 'left',

            },
            {
                element: '.tour-employeename',
                intro: "Enter the employee full name.",
                position: 'left',

            },

            {
                element: '.tour-employeepseudoname',
                intro: "Enter the employee pseudo name ",
                position: 'left',

            },
            {
                element: '.tour-employeeemail',
                intro: "Enter the employee email address.",
                position: 'left',

            },
            {
                element: '.tour-employeepseudoemail',
                intro: "Enter the employee pseudo email ",
                position: 'left',

            },

            {
                element: '.tour-employeedesignation',
                intro: "Mention the job title/designation.",
                position: 'left',

            },
            {
                element: '.tour-employeegender',
                intro: "Select the employee gender.",
                position: 'left',

            },
            {
                element: '.tour-employeephone',
                intro: "Enter the primary contact number.",
                position: 'left',

            },
            {
                element: '.tour-employeepseudophone',
                intro: "Enter the pseudo contact number.",
                position: 'left',

            },
            {
                element: '.tour-employeeimage',
                intro: "Upload the employee profile picture.",
                position: 'left',

            },
            {
                element: '.tour-employeeaddress',
                intro: "Enter the complete residential address.",
                position: 'left',

            },
            {
                element: '.tour-employeecity',
                intro: "Enter the city of residence.",
                position: 'left',

            },
            {
                element: '.tour-employeestate',
                intro: "Enter the state or province.",
                position: 'left',

            },
            {
                element: '.tour-employeecountry',
                intro: "Select the country of residence.",
                position: 'left',

            },
            {
                element: '.tour-employeepostalcode',
                intro: "Enter the ZIP/postal code.",
                position: 'left',

            },
            {
                element: '.tour-employeedob',
                intro: "Enter the birth date.",
                position: 'left',

            },
            {
                element: '.tour-employeedoj',
                intro: "Enter the joining date.",
                position: 'left',

            },
            {
                element: '.tour-employeetarget',
                intro: "Enter the employee’s monthly performance target.",
                position: 'left',

            },

            {
                element: '.tour-employeepassword',
                intro: "Either manually enter or auto-generate a password.",
                position: 'left',

            },
            {
                element: '.tour-employeestatus',
                intro: "Set as Active or Inactive.",
                position: 'left',

            },
            {
                element: '.tour-employeesubmit',
                intro: "Click & create employee",
                position: 'left',

            },


        ],

    },

    invoices: {
        steps: [
            {
                element: '.tour-invoicetitle',
                intro: "Invoice related Data",
                position: 'right'
            },
            {
                element: '.tour-invoicealldata',
                intro: "This table displays all invoices like customer name, date, amount, and status.",
                position: 'top'
            },
            {
                element: '.tour-invoiceaction',
                intro: "Use these actions to manage the invoice. like copy invoice url , edit & delete invoice.",
                position: 'top'
            },


        ],
    },
    invoicecreate: {
        steps: [
            {
                element: '.tour-createinvoice',
                intro: "Click to create a new invoice",
                position: 'left',
                requireClick: true

            },

            {
                element: '.tour-invoicecreation',
                intro: "You can create or edit a invoice",
                position: 'left',
                hideBack: true


            },
            {
                element: '.tour-invoicecreatebrand',
                intro: "Choose the brand.",
                position: 'left',


            },
            {
                element: '.tour-invoicecreateteam',
                intro: "Select the team.",
                position: 'left',


            },

            {
                element: '.tour-invoiceusertype',
                intro: "'UPSALE' Select an existing customer 'FRESH'  Create an invoice for a new customer ",
                position: 'left',

            },
            // {
            //     element: '.tour-invoicecusselect',
            //     intro: "Pick the customer contact.",
            //     position: 'left',
            //
            //
            // },
            {
                element: '.tour-invoiceagentselect',
                intro: "Select the agent.",
                position: 'left',


            },
            {
                element: '.tour-invoicedateselect',
                intro: "Set the invoice due date.",
                position: 'left',

            },
            {
                element: '.tour-invoicecurselect',
                intro: "All invoices are processed in (USD).",
                position: 'left',

            },
            {
                element: '.tour-invoicemerchant',
                intro: "Select Payment Merchants",
                position: 'left',


            },
            {
                element: '.tour-invoiceamount',
                intro: "Enter the invoice amount.",
                position: 'left',


            },

            {
                element: '.tour-invoicetax',
                intro: "To apply tax, check the box first. Then select the tax type and enter tax amount.",
                position: 'left',

            },
            {
                element: '.tour-invoicetotal',
                intro: "Total payable amount. including & excluding tax",
                position: 'left',

            },
            {
                element: '.tour-invoicedesc',
                intro: "Add invoice description.",
                position: 'left',

            },
            {
                element: '.tour-invoicecomplete',
                intro: "Click & Create a Invoice",
                position: 'left',


            },
        ],
    },

    payment: {
        steps: [
            {
                element: '.tour-paymenttitle',
                intro: "Payment related Data",
                position: 'right'
            },
            {
                element: '.tour-paymentalldata',
                intro: "This table displays all payments create data.",
                position: 'top'
            },


        ],
    },
    paymentcreate: {
        steps: [
            {
                element: '.tour-createpayment',
                intro: "Click to create a Payment",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-paymentcreation',
                intro: "You can create or edit a payment",
                position: 'left',
                hideBack: true

            },
            {
                element: '.tour-paymentwithinvoice',
                intro: "Choose an existing invoice or create a new one for payment.",
                position: 'left',

            },
            {
                element: '.tour-paymentbrand',
                intro: "Pick the relevant brand.",
                position: 'left',

            },

            {
                element: '.tour-paymentteam',
                intro: "Choose the team involved.",
                position: 'left',

            },

            {
                element: '.tour-paymentagent',
                intro: "Select the responsible agent.",
                position: 'left',

            },
            {
                element: '.tour-paymentcustype',
                intro: "'UPSALE' Select an existing customer 'FRESH'  Create an payment for a new customer ",
                position: 'left',

            },
            // {
            //     element: '.tour-paymentcuscontact',
            //     intro: "Pick the customer contact.",
            //     position: 'left',
            //
            // },
            {
                element: '.tour-paymentamount',
                intro: "Enter the payment amount.",
                position: 'left',

            },
            {
                element: '.tour-paymentaccount',
                intro: "Choose the client account.",
                position: 'left',


            },
            {
                element: '.tour-paymentdate',
                intro: "Set the date of payment.",
                position: 'left',

            },
            {
                element: '.tour-paymenttrid',
                intro: "Enter the transaction ID for reference.",
                position: 'left',

            },
            {
                element: '.tour-paymentsubmit',
                intro: "Click & create payment",
                position: 'left',

            },


        ],
    },

    client_contact: {
        steps: [
            {
                element: '.tour-clientcontacttitle',
                intro: "Client contact related Data",
                position: 'right'
            },
            {
                element: '.tour-clientcontactalldata',
                intro: "This table displays all client contact create data.",
                position: 'top'
            },
            {
                element: '.tour-clientcontactstatus',
                intro: "You can change status like active inactive",
                position: 'top'
            },
            {
                element: '.tour-clientcontactaction',
                intro: "You can edit or delete client contact",
                position: 'top'
            },


        ],
    },
    client_contact_create: {
        steps: [
            {
                element: '.tour-createclientcontact',
                intro: "Click to create a client contact",
                position: 'left',
                requireClick: true
            },
            {
                element: '.tour-clientcontactcreation',
                intro: "You can create or edit a client contact",
                position: 'left',
                hideBack: true
            },
            {
                element: '.tour-clientcontactbrand',
                intro: "Choose one or multiple associated brands.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactname',
                intro: " Enter the client contact’s full name.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactemail',
                intro: "Enter the client contact’s email.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactphone',
                intro: "Enter the contact number.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactaddress',
                intro: "Add the complete address.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactcity',
                intro: "Enter the city name.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactstate',
                intro: "Enter the state or province.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactcountry',
                intro: "Choose the country.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactzip',
                intro: "Enter the postal/ZIP code.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactstatus1',
                intro: "Set status as Active or Inactive.",
                position: 'left'
            },
            {
                element: '.tour-clientcontactsubmit',
                intro: "Click & create a client contact",
                position: 'left',

            },



        ],
    },

    client_company: {
        steps: [
            {
                element: '.tour-clientcompanytitle',
                intro: "Client company related Data",
                position: 'right'
            },
            {
                element: '.tour-clientcompanyalldata',
                intro: "This table displays all client company data like contact, logo, name, email, status etc",
                position: 'top'
            },

            {
                element: '.tour-clientcompanyaction',
                intro: "You can edit or delete client company",
                position: 'top'
            },


        ],
    },

    client_company_create: {
        steps: [
            {
                element: '.tour-createclientcompany',
                intro: "Click to create a client company",
                position: 'left',
                requireClick: true
            },
            {
                element: '.tour-clientcompanycreation',
                intro: "You can create or edit a client company",
                position: 'left',
                hideBack: true
            },
            {
                element: '.tour-clientcompanybrand',
                intro: "Link the company with one or more brands.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanycontact',
                intro: "Choose the associated client contact.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanyname',
                intro: "Enter the company name.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanyemail',
                intro: "Enter the company’s email address.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanyurl',
                intro: "Add the company’s website link.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanylogo',
                intro: "Upload the company logo.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanydesc',
                intro: "Enter a short description of the company.",
                position: 'left'
            },

            {
                element: '.tour-clientcompanystatus',
                intro: "Set the company status as Active or Inactive.",
                position: 'left'
            },
            {
                element: '.tour-clientcompanysubmit',
                intro: "Click & create a client company",
                position: 'left',

            },

        ],
    },

    client_account: {
        steps: [
            {
                element: '.tour-clientaccounttitle',
                intro: "Client Account related Data",
                position: 'right'
            },
            {
                element: '.tour-clientaccountalldata',
                intro: "This table displays all client account data like contact, company, payment method, descriptor, transaction key etc",
                position: 'top'
            },
            {
                element: '.tour-clientaccountstatus',
                intro: "You can change status like active inactive",
                position: 'top'
            },

            {
                element: '.tour-clientaccountaction',
                intro: "You can edit or delete client account",
                position: 'top'
            },


        ],
    },

    client_account_create: {
        steps: [
            {
                element: '.tour-createclientaccount',
                intro: "Click to create a client account",
                position: 'left',
                requireClick: true
            },
            {
                element: '.tour-clientaccountcreation',
                intro: "You can create or edit a client account",
                position: 'left',
                hideBack: true
            },
            {
                element: '.tour-clientaccountbrand',
                intro: "Choose one or multiple associated brands.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountmethod',
                intro: "Based on the method (Authorize/Stripe or Bank Transfer), show relevant fields.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountcontact',
                intro: "Choose the linked client contact.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountcompany',
                intro: "Select the associated client company.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountname',
                intro: "Name , If bank is selected, enter the account title.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountdescriptor',
                intro: "Enter the statement descriptor.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountvendor',
                intro: "Enter the vendor name.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountemail',
                intro: "Enter the account-related email address.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountloginid',
                intro: "Enter the login ID (for gateways like Authorize/Stripe).",
                position: 'left'
            },
            {
                element: '.tour-clientaccounttrkey',
                intro: "Provide the transaction key (for gateways like Authorize/Stripe).",
                position: 'left'
            },
            {
                element: '.tour-clientaccountmaxtr',
                intro: "Set the maximum allowed per transaction.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountmonthlyvol',
                intro: "Define the expected monthly transaction volume.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountenv',
                intro: "Choose the environment (Live or Test).",
                position: 'left'
            },
            {
                element: '.tour-clientaccountstatus1',
                intro: "Set account status as Active or Inactive.",
                position: 'left'
            },
            {
                element: '.tour-clientaccountsubmit',
                intro: "Click & create client account",
                position: 'left'
            },

        ],
    },

    customer_contact: {
        steps: [
            {
                element: '.tour-contacttitle',
                intro: "Customer contact related Data",
                position: 'right'
            },
            {
                element: '.tour-contactalldata',
                intro: "This table displays all Customer data like name, email, brand, team , status.",
                position: 'top'
            },
            {
                element: '.tour-contactaction',
                intro: "Use these actions to manage customer contact data like delete",
                position: 'top'
            },


        ],
    },
    customer_contact_create: {
        steps: [
            {
                element: '.tour-createcustomer',
                intro: "Click to create a Customer contact",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-admincreation',
                intro: "You can create customer contact",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-contactbrand',
                intro: "Choose the associated brand.",
                position: 'left',

            },

            {
                element: '.tour-contactteam',
                intro: "Select the responsible team.",
                position: 'left',

            },

            {
                element: '.tour-contactname',
                intro: "Enter the customer's full name.",
                position: 'left',

            },
            {
                element: '.tour-contactemail',
                intro: "Enter the customer’s email address.",
                position: 'left',

            },
            {
                element: '.tour-contactphone',
                intro: "Enter the contact number.",
                position: 'left',

            },
            {
                element: '.tour-contactaddress',
                intro: "Add the customer’s full address.",
                position: 'left',

            },
            {
                element: '.tour-contactcity',
                intro: "Enter the city name.",
                position: 'left',

            },
            {
                element: '.tour-contactcountry',
                intro: "Choose the country",
                position: 'left',

            },
            {
                element: '.tour-contactstate',
                intro: "Enter the state or region.",
                position: 'left',

            },
            {
                element: '.tour-contactzip',
                intro: "Enter the postal/ZIP code.",
                position: 'left',

            },
            {
                element: '.tour-contactstatus',
                intro: "Set the contact as Active or Inactive.",
                position: 'left',

            },
            {
                element: '.tour-contactsubmit',
                intro: "Click & create customer contact",
                position: 'left',

            },


        ],
    },

    brands: {
        steps: [
            {
                element: '.tour-brandtitle',
                intro: "Brand related data",
                position: 'right'
            },
            {
                element: '.tour-brandalldata',
                intro: "This table displays all brand data like brandkey, name, url, status",
                position: 'top'
            },
            {
                element: '.tour-brandstatus',
                intro: "You can change status like active inactive",
                position: 'top'
            },
            {
                element: '.tour-contactaction',
                intro: "Use these actions to manage brand data like edit & delete",
                position: 'top'
            },


        ],
    },
    brand_create: {
        steps: [
            {
                element: '.tour-createbrand',
                intro: "Click to create a new brand",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-brandcreation',
                intro: "You can create a new brand",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-brandname',
                intro: "Enter the brand name.",
                position: 'left',

            },

            {
                element: '.tour-brandemail',
                intro: "Enter the brand’s email address.",
                position: 'left',

            },

            {
                element: '.tour-brandurl',
                intro: "Enter the brand’s website link.",
                position: 'left',

            },
            {
                element: '.tour-brandlogo',
                intro: "Upload the brand logo.",
                position: 'left',

            },
            {
                element: '.tour-branddesc',
                intro: "Add a brief description of the brand.",
                position: 'left',

            },
            {
                element: '.tour-brandmerchants',
                intro: "Choose one or more associated payment merchants.",
                position: 'left',

            },

            {
                element: '.tour-brandsubmit',
                intro: "Click & create a new brand",
                position: 'left',

            },

        ],
    },

    teams: {
        steps: [
            {
                element: '.tour-teamtitle',
                intro: "Team related data",
                position: 'right'
            },
            {
                element: '.tour-teamalldata',
                intro: "This table displays all team data like name, description, assignd brands, team lead",
                position: 'top'
            },
            {
                element: '.tour-teamstatus',
                intro: "You can change status like active inactive",
                position: 'top'
            },
            {
                element: '.tour-teamaction',
                intro: "Use these actions to manage team data like edit & delete",
                position: 'top'
            },


        ],
    },
    team_create: {
        steps: [
            {
                element: '.tour-createteam',
                intro: "Click to create a new team",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-teamcreation',
                intro: "You can create a new team",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-teamname',
                intro: "Enter the name of the team.",
                position: 'left',

            },

            {
                element: '.tour-teamlead',
                intro: "Choose the team lead.",
                position: 'left',

            },

            {
                element: '.tour-teamdesc',
                intro: "Add a brief description of the team.",
                position: 'left',

            },
            {
                element: '.tour-teammember',
                intro: "Choose one or more team members.",
                position: 'left',

            },
            {
                element: '.tour-teambrand',
                intro: "Associate one or more brands with the team.",
                position: 'left',

            },

            {
                element: '.tour-teamsubmit',
                intro: "Click & create a new team",
                position: 'left',

            },

        ],
    },

    lead_status: {
        steps: [
            {
                element: '.tour-leadstatustitle',
                intro: "Lead status related data",
                position: 'right'
            },
            {
                element: '.tour-leadstatusalldata',
                intro: "This table displays all lead status data like name, color, description, status",
                position: 'top'
            },
            {
                element: '.tour-leadstatus',
                intro: "You can change status like active inactive",
                position: 'top'
            },
            {
                element: '.tour-leadstatusaction',
                intro: "Use these actions to manage lead status data like edit & delete",
                position: 'top'
            },


        ],
    },
    lead_status_create: {
        steps: [
            {
                element: '.tour-createleadstatus',
                intro: "Click to create a new lead status",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-leadstatuscreation',
                intro: "You can create a new lead status",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-leadstatusname',
                intro: " Enter the name of the lead status.",
                position: 'left',

            },

            {
                element: '.tour-leadstatuscolor',
                intro: "Pick a color to represent this status.",
                position: 'left',

            },

            {
                element: '.tour-leadstatusdesc',
                intro: "Add a short description for the status.",
                position: 'left',

            },
            {
                element: '.tour-leadstatuss',
                intro: "Set as Active or Inactive.",
                position: 'left',

            },
            {
                element: '.tour-leadstatussubmit',
                intro: "Click & create a new lead status",
                position: 'left',

            },

        ],
    },

    lead: {
        steps: [
            {
                element: '.tour-leadtitle',
                intro: "Leads related data",
                position: 'right'
            },
            {
                element: '.tour-leadalldata',
                intro: "This table displays all lead status data like brand, team, customer contact, status",
                position: 'top'
            },

            {
                element: '.tour-leadaction',
                intro: "Use these actions to manage lead data like edit & delete",
                position: 'top'
            },


        ],
    },
    lead_create: {
        steps: [
            {
                element: '.tour-createlead',
                intro: "Click to create a new lead",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-leadcreation',
                intro: "You can create a new lead",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-leadbrand',
                intro: "Choose the brand linked to the lead.",
                position: 'left',

            },

            {
                element: '.tour-leadteam',
                intro: "Assign the lead to a team.",
                position: 'left',

            },

            {
                element: '.tour-leadname',
                intro: "Enter the lead's full name.",
                position: 'left',

            },
            {
                element: '.tour-leademail',
                intro: "Enter the lead’s email address.",
                position: 'left',

            },
            {
                element: '.tour-leadphone',
                intro: "Enter the contact number.",
                position: 'left',

            },
            {
                element: '.tour-leadtype',
                intro: " Choose the type/category of the lead.",
                position: 'left',

            },
            {
                element: '.tour-leadnote',
                intro: "Add any relevant notes or comments.",
                position: 'left',

            },
            {
                element: '.tour-leadsstatus',
                intro: "Set the lead status (Active or Inactive).",
                position: 'left',

            },
            {
                element: '.tour-leadsubmit',
                intro: "Click & create a new lead",
                position: 'left',

            },

        ],
    },

    user_dashboard: {
        steps: [
            {
                element: '.tour-userdashboard-alldata',
                intro: "This section displays a quick overview of the login user CRM's total performance for the current month.",
                position: 'right'
            },
            {
                element: '.tour-userdashboardsales',
                intro: "This section shows the total sales you’ve made in the current month",
                position: 'top'
            },
            {
                element: '.tour-userdashboardtarget',
                intro: "This shows your sales target for the month ",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardfreshinvoice',
                intro: "This displays the total value of new sales made during the current month.",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardupdsaleinvoice',
                intro: " This shows the total amount earned from upselling to existing customers.",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardinvoicedata',
                intro: "Sum of all total invoices PAID,DUE,REFUND,CHARGEBACK",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardmonthlydata',
                intro: "Shows date-wise payment received for the current month.",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardyearlydata',
                intro: "Displays total payment received each month throughout the current year.",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardrecenpayment',
                intro: "List of most recent payments received for this month in the CRM.",
                position: 'top'
            }
            ,
            {
                element: '.tour-userdashboardleadprogress',
                intro: "Visual chart showing lead for this month counts by status like New, Contracted, Qualified, etc.",
                position: 'left'
            }
            ,
            {
                element: '.tour-userdashboardaymentprogress',
                intro: "Shows the count of Paid, Refunded, and Chargeback transactions this month.",
                position: 'left'
            }
            ,
            {
                element: '.tour-userdashboardoverallprogress',
                intro: "Displays total counts of leads, customers, invoices, and payments. Hover over each section for exact numbers for this month",
                position: 'left'
            }
        ],

    },

    user_customer_contact: {
        steps: [
            {
                element: '.tour-usercontacttitle',
                intro: "Customer contact related Data",
                position: 'right'
            },
            {
                element: '.tour-usercontactalldata',
                intro: "This section displays all the contacts added by you .This table displays all Customer data like brand, name, email, phone etc.",
                position: 'top'
            },

        ],
    },
    user_customer_contact_create: {
        steps: [
            {
                element: '.tour-usercreatecustomer',
                intro: "Click to create a Customer contact",
                position: 'left',
                requireClick: true

            },
            {
                element: '.tour-usercontactcreation',
                intro: "You can create customer contact",
                position: 'left',
                hideBack: true

            },

            {
                element: '.tour-usercontactbrand',
                intro: "Choose the associated brand.",
                position: 'left',

            },

            {
                element: '.tour-usercontactteam',
                intro: "Select your team.",
                position: 'left',

            },

            {
                element: '.tour-usercontactname',
                intro: "Enter the customer's full name.",
                position: 'left',

            },
            {
                element: '.tour-usercontactemail',
                intro: "Enter the customer’s email address.",
                position: 'left',

            },
            {
                element: '.tour-usercontactphone',
                intro: "Enter the contact number.",
                position: 'left',

            },
            {
                element: '.tour-usercontactaddress',
                intro: "Add the customer’s full address.",
                position: 'left',

            },
            {
                element: '.tour-usercontactcity',
                intro: "Enter the city name.",
                position: 'left',

            },
            {
                element: '.tour-usercontactcountry',
                intro: "Choose the country",
                position: 'left',

            },
            {
                element: '.tour-usercontactstate',
                intro: "Enter the state or region.",
                position: 'left',

            },
            {
                element: '.tour-usercontactzip',
                intro: "Enter the postal/ZIP code.",
                position: 'left',

            },
            {
                element: '.tour-usercontactstatus',
                intro: "Set the contact as Active or Inactive.",
                position: 'left',

            },
            {
                element: '.tour-usercontactsubmit',
                intro: "Click & create customer contact",
                position: 'left',

            },


        ],
    },

    user_teams: {
            steps: [
                {
                    element: '.tour-userteamtitle',
                    intro: "Team related data",
                    position: 'right'
                },
                {
                    element: '.tour-userteamalldata',
                    intro: "Here you can see all the members of your team. The team lead is highlighted with a star",
                    position: 'top'
                },

            ],
        },
    user_brands: {
        steps: [
            {
                element: '.tour-userbrandtitle',
                intro: "Brand related data",
                position: 'right'
            },
            {
                element: '.tour-userbrandalldata',
                intro: "You’ll only see the brands that are assigned to your team.",
                position: 'top'
            },

        ],
    },

    user_leads: {
        steps: [
            {
                element: '.tour-userleadtitle',
                intro: "Leads related data",
                position: 'right'
            },
            {
                element: '.tour-userleadalldata',
                intro: "All leads created under the brands and teams assigned to you will appear here.",
                position: 'top'
            },

        ],
    },

    user_invoice: {
        steps: [
            {
                element: '.tour-userinvoicetitle',
                intro: "Invoice related Data",
                position: 'right'
            },
            {
                element: '.tour-userallinvoice',
                intro: "This section lists all invoices related to your assigned team.",
                position: 'top'
            },
            {
                element: '.tour-useronlyinvoice',
                intro: " This section shows only the invoices you’ve personally created.",
                position: 'top'
            },
            {
                element: '.tour-userinvoiceaction',
                intro: "Use these actions to manage the invoice. like copy invoice url , edit invoice.",
                position: 'top'
            },


        ],
    },
    user_invoicecreate: {
        steps: [
            {
                element: '.tour-usercreateinvoice',
                intro: "Click to create a new invoice",
                position: 'left',
                requireClick: true

            },

            {
                element: '.tour-userinvoicecreation',
                intro: "You can create or edit a invoice",
                position: 'left',
                hideBack: true


            },
            {
                element: '.tour-userinvoicecreatebrand',
                intro: "Choose the brand.",
                position: 'left',


            },
            {
                element: '.tour-userinvoicecreateteam',
                intro: "Select the team.",
                position: 'left',


            },

            {
                element: '.tour-userinvoiceusertype',
                intro: "'UPSALE' Select an existing customer 'FRESH'  Create an invoice for a new customer ",
                position: 'left',

            },
            // {
            //     element: '.tour-invoicecusselect',
            //     intro: "Pick the customer contact.",
            //     position: 'left',
            //
            //
            // },
            {
                element: '.tour-userinvoiceagentselect',
                intro: "Select the agent.",
                position: 'left',


            },
            {
                element: '.tour-userinvoicedateselect',
                intro: "Set the invoice due date.",
                position: 'left',

            },
            {
                element: '.tour-userinvoicecurselect',
                intro: "All invoices are processed in (USD).",
                position: 'left',

            },
            {
                element: '.tour-userinvoicemerchant',
                intro: "Select Payment Merchants",
                position: 'left',


            },
            {
                element: '.tour-userinvoiceamount',
                intro: "Enter the invoice amount.",
                position: 'left',


            },

            {
                element: '.tour-userinvoicetax',
                intro: "To apply tax, check the box first. Then select the tax type and enter tax amount.",
                position: 'left',

            },
            {
                element: '.tour-userinvoicetotal',
                intro: "Total payable amount. including & excluding tax",
                position: 'left',

            },
            {
                element: '.tour-userinvoicedesc',
                intro: "Add invoice description.",
                position: 'left',

            },
            {
                element: '.tour-userinvoicecomplete',
                intro: "Click & Create a Invoice",
                position: 'left',


            },
        ],
    },

    user_payment: {
        steps: [
            {
                element: '.tour-userpaymenttitle',
                intro: "Payment related Data",
                position: 'right'
            },
            {
                element: '.tour-userallpayment',
                intro: "This section lists all payment related to your assigned team.",
                position: 'top'
            },
            {
                element: '.tour-useronlypayment',
                intro: " This section shows only the payment your invoice paid.",
                position: 'top'
            },

        ],
    },
    kpi_dashboard_1: {
        steps: [
            {
                element: '.tour-kpi-dashboard1-alldata',
                intro: "View sales performance by selecting team, brand, and date, and download the report as PDF.",
                position: 'right'
            },
            {
                element: '.tour-kpi-dashboard1-team',
                intro: 'Choose a specific team to filter data .',
                position: 'bottom',
            },
            {
                element: '.tour-kpi-dashboard1-brand',
                intro: "After selecting a team, pick a brand to view its related metrics.",
                position: 'bottom'
            },
            {
                element: '.tour-kpi-dashboard1-date',
                intro: "Set a custom date range to view data for a specific time period.",
                position: 'bottom'
            },
            {
                element: '.tour-kpi-dashboard1-tabledata',
                intro: "See detailed sales KPIs for each user including Target, Commission, Wire SPIFF, Lead bonus and total earnings.",
                position: 'bottom'
            },


        ],

    },



};


let currentTour = null;

function startTour(tourName) {
    // Cancel existing tour if running
    if (currentTour && currentTour.isActive()) {
        return;

    }


    const tourData = tours[tourName];
    const tour = new Shepherd.Tour({
        defaultStepOptions: {
            scrollTo: { behavior: 'smooth', block: 'center' },
            cancelIcon: { enabled: true },
            classes: 'shadow-md bg-purple-dark',
            buttons: []
        }
    });

    tourData.steps.forEach((step, index) => {
        let buttons = [];

        if (index > 0 && !step.requireClick && !step.hideBack) {
            buttons.push({
                text: '<i class="fas fa-arrow-left icon-left"></i>',
                action: tour.back,
                classes: 'tour-btn'
            });
        } else {
            buttons.push({
                text: '',
                action: function () { },
                classes: 'tour-btn invisible-button',
                disabled: true
            });
        }

        if (!step.requireClick) {
            const isLast = index === tourData.steps.length - 1;
            const iconClass = isLast ? 'fas fa-check' : 'fas fa-arrow-right';
            const label = isLast ? '' : '';

            buttons.push({
                text: `${label} <i class="${iconClass} icon-right"></i>`,
                action: tour.next,
                classes: 'tour-btn'
            });
        }

        tour.addStep({
            text: step.intro,
            attachTo: {
                element: step.element,
                on: step.position || 'bottom'
            },
            buttons: buttons,
            when: {
                show: function () {
                    if (step.requireClick) {
                        const el = document.querySelector(step.element);
                        if (el) {
                            const eventType = el.tagName.toLowerCase() === 'select' ? 'change' : 'click';
                            const handler = () => {
                                el.removeEventListener(eventType, handler);

                                setTimeout(() => {
                                    tour.next();
                                }, 100);
                            };
                            el.addEventListener(eventType, handler);
                        }
                    }
                }
            }
        });
    });

    tour.on('complete', tourData.onComplete || (() => {}));

    tour.start();
    currentTour = tour;

    // document.addEventListener('click', function (e) {
    //     if (e.target.classList.contains('close-btn')) {
    //         if (currentTour) {
    //             currentTour.cancel();
    //             currentTour = null;
    //         }
    //     }
    // });

    function cancelTourIfRunning() {
        if (currentTour) {
            currentTour.cancel();
            currentTour = null;
        }
    }

// 1️⃣ Close via .close-btn
    $('.close-btn').on('click', function () {
        cancelTourIfRunning();
    });


}




