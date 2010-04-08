
# Here is the class I will distribute with the PHP framework

BRIDGE_MODE_QBXML = 'qbxml'
BRIDGE_MODE_YAML = 'yaml'

class QuickBooks_Bridge_Python:
    
    def __init__(self, url_to_bridge='', mode='qbxml'):
        pass
    
    # Send a request to the framework vai the bridge, and gets the request queued up
    def send(self, qbxml):
        
        socket = open a socket ot the remote PHP server
        POST the data to the remote PHP server
        return true or false 
    
    # Receives data POSTed back from the bridge, and calls a handler function
    def handle(self):
        pass
   
# --------------------------------------------------







 
    
    
#!/usr/bin/python
# this is the pythons cript that is sending requests to the framework to get things done


import QuickBooks_Bridge_Python

qbxml = " ... <QBXML><AddInvoice><RefNumber>2</RebNumber><Amount>195</Amount></AddInvoice></QBXML> ... ";

bridge = QuickBook_Python_Bridge('http://path/to/bridge_server.php')
if (bridge.send(qbxml))
{
    print 'command queued successfully!'
}
else
{
    print 'uh oh... something went wrong!'
}

#---------------------------------------   
   
    
    
    
    
    
#!/usr/bin/python
# this is the python script that handles responses

import QuickBooks_Bridge_Python

# This is my python function that handles responses
def my_function_handler(requestID, action, ident, qbxml):
    
    if action == 'CustomerAdd':
        # parse the CustomerAddRs response and do whatever with it
        # ...
    elif action == 'InvoiceAdd':
        # parse the InvoiceAddRs and do whatever with it...
        # ... 

bridge = QuickBooks_Bridge_Python()
bridge.handle('my_function_handler')


#--------------------------------------