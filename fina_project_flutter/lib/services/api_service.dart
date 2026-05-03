import 'package:dio/dio.dart';
import '../models/passport_model.dart';

class ApiService {
  final Dio _dio;

  // Base URL for Android Emulator localhost.
  // Change to your machine's local IPv4 (e.g., 'http://192.168.1.X:8000/api/') for physical devices.
  static const String baseUrl = 'http://192.168.0.108:8000/api/';

  ApiService() : _dio = Dio(BaseOptions(baseUrl: baseUrl));

  Future<PassportModel> trackPassport(String serialNumber) async {
    try {
      final response = await _dio.get('track-passport/$serialNumber');

      if (response.statusCode == 200 && response.data['success'] == true) {
        return PassportModel.fromJson(response.data['data']);
      } else {
        throw Exception('Failed to load passport data.');
      }
    } on DioException catch (e) {
      if (e.response != null && e.response?.data != null) {
        // Extract message from the Laravel API response (e.g., 404 Not Found)
        final message =
            e.response?.data['message'] ?? 'An unknown error occurred';
        throw Exception(message);
      } else {
        throw Exception(e.message ?? 'Network error occurred');
      }
    } catch (e) {
      throw Exception(e.toString());
    }
  }
}
