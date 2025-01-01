# Import the ZAP library
from zapv2 import ZAPv2
import time

# ZAP configuration
zap_url = 'http://localhost:8080'  # URL where ZAP is running

api_key = 'v7mml9cmqcgev07m96fehk4js8'
target_url = 'http://192.168.183.1/tutorial2'#or 192.168.220.1
# Initialize ZAP API client
zap = ZAPv2(apikey=api_key, proxies={'http': zap_url, 'https': zap_url})

# Function to perform an active scan
def zap_active_scan():
    print(f'Starting scan on target: {target_url}')

    # Spidering the target URL
    print('Spidering the target...')
    spider_id = zap.spider.scan(target_url)
    while int(zap.spider.status(spider_id)) < 100:
        print(f'Spider progress: {zap.spider.status(spider_id)}%')
        time.sleep(2)
    print('Spidering completed!')

    # Active scanning the target
    print('Starting active scan...')
    scan_id = zap.ascan.scan(target_url)
    while int(zap.ascan.status(scan_id)) < 100:
        print(f'Scan progress: {zap.ascan.status(scan_id)}%')
        time.sleep(5)
    print('Active scan completed!')

    # Fetch and print the scan results
    print('Scan completed. Fetching alerts...')
    alerts = zap.core.alerts(baseurl=target_url)
    for alert in alerts:
        print(f"Alert: {alert['alert']}")
        print(f"Risk: {alert['risk']}")
        print(f"Description: {alert['description']}")
        print('-' * 20)

# Function to save scan results to a file
def save_scan_report():
    # Save results in HTML format
    with open('zap_report.html', 'w') as f:
        f.write(zap.core.htmlreport())
    print('Report saved as zap_report.html')

# Run the ZAP scan and save the report
zap_active_scan()
save_scan_report()
