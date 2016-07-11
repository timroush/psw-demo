import unittest
from selenium import webdriver
from selenium.webdriver.common.keys import Keys

class PythonOrgSearch(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Firefox()

    def test_content(self):
        self.driver.get("http://www.roushworks.com/psw-demo")
        self.assertIn("Leslie's/Pool Supply World", self.driver.title)
        elem = self.driver.find_element_by_name("username")
        elem.send_keys("Tim")
        elem.send_keys(Keys.RETURN)
        self.assertIn("Hello, Tim", self.driver.page_source)
        self.assertIn("Restaurants", self.driver.page_source)
        self.assertIn("Suggest A Restaurant", self.driver.page_source)
        self.assertIn("Ratings History", self.driver.page_source)

    def tearDown(self):
        self.driver.close()

if __name__ == "__main__":
    unittest.main()